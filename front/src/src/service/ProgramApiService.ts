import ProgramModel from "@/models/ProgramModel";
import httpClient from "@/service/http.client";

export default class ProgramApiService {
	private API_ENDPOINT = "statistics/direction";
	private AVG_STATISTICS_ENDPOINT = "statistics/avg";
	private REPORT_ENDPOINT = "report";

	public async getAllPrograms(): Promise<ProgramModel[]> {
		const response = await httpClient().get(`${this.API_ENDPOINT}/all.php`);

		return response.data.records.map((p: any) => new ProgramModel(p));
	}

  public async getProgramReports(code: string): Promise<any> {
    let response;
    let chart_score_resp;
    let chart_score;
    chart_score_resp = await httpClient().get(
      `${this.REPORT_ENDPOINT}/values.php?spec=${code}&year=2019`
    );
    chart_score = chart_score_resp.data.records[0]
    return [chart_score];
  }

	public async getProgramAllStatistics(code: string, year: string[]): Promise<any> {
		const res = [];

		let response;
		let chart_score_resp;
		let chart_score;
		let currentStatistics = [];

		function create_color_func(alarm: Number, warning: Number) {
			return function(value: Number) {
				if (value < alarm) {
					return "rgba(221, 111, 76, #{opacity})";
				} else if (value < warning) {
					return "rgba(231, 234, 78, #{opacity})";
				} else {
					return "rgba(107, 203, 151, #{opacity})";
				}
			};
		}

    chart_score_resp = await httpClient().get(
      `${this.REPORT_ENDPOINT}/values.php?spec=${code}&year=2019`
    );
    chart_score = chart_score_resp.data.records[0]

		for (const y of year) {
			// Средний балл по специальности
			response = await httpClient().get(
				`${this.AVG_STATISTICS_ENDPOINT}/programvalue.php?spec=${code}&year=${y}`
			);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_program,
				color_func: create_color_func(30, 50)
			});
		}

		res.push({
			score: chart_score.program_value,
			title: "Ср. балл",
			data: currentStatistics
		});

		currentStatistics = [];

		for (const y of year) {
			// Специалисты которые работают по специальности по годам и направелниям
			response = await httpClient().get(
				`${this.AVG_STATISTICS_ENDPOINT}/workspecialist.php?spec=${code}&year=${y}`
			);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_value,
				color_func: create_color_func(20, 51)
			});
		}

		res.push({
			score: chart_score.work_value,
			title: "Работа по специальности",
			data: currentStatistics
		});

		currentStatistics = [];

		for (const y of year) {
			// Процент удовлетворенности выпускников практическими навыками к общему числу студентов выпусников по годам
			response = await httpClient().get(
				`${this.AVG_STATISTICS_ENDPOINT}/practicalskills.php?spec=${code}&year=${y}`
			);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_value,
				color_func: create_color_func(50, 71)
			});
		}

		res.push({
			score: 10,
			title: "% довольных практическими навыками",
			data: currentStatistics
		});

		currentStatistics = [];

		for (const y of year) {
			// Процент освоение программы
			response = await httpClient().get(
				`${this.AVG_STATISTICS_ENDPOINT}/excellentstudent.php?spec=${code}&year=${y}`
			);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_value,
				color_func: create_color_func(30, 61)
			});
		}

		res.push({
			score: chart_score.excellent,
			title: "% усвоение программы",
			data: currentStatistics
		});

		currentStatistics = [];

		for (const y of year) {
			// %преподоватей с рейтингом от студентов больше 5
			response = await httpClient().get(
				`${this.AVG_STATISTICS_ENDPOINT}/teachstudentrating.php?spec=${code}&year=${y}`
			);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_value,
				color_func: create_color_func(20, 50)
			});
		}

		res.push({

			score: chart_score.teachstudentrating,
			title: "% преп. с высоким студ.рейтингом",
			data: currentStatistics
		});

		currentStatistics = [];

		for(const y of year) {
			// % преп. h-Scopus > 2
			response = await httpClient()
				.get(`${this.AVG_STATISTICS_ENDPOINT}/hirschvalue.php?spec=${code}&year=${y}`);

			currentStatistics.push({
				year: y,
				value: response.data.records[0].avg_value,
        color_func: create_color_func(20, 50)
			})
		}

		res.push({
			score: chart_score.hirsch,
			title: "% преп. h-Scopus > 2",
			data: currentStatistics
		})

		currentStatistics = [];

		return res;
	}
}
