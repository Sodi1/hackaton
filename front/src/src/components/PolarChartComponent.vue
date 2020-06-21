<template>
	<div class="chart-component">
		<div class="chart">
			<canvas ref="chart" width="400" height="400" class="chart"></canvas>
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from "vue-property-decorator";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/ru";
import Chart from "chart.js";

@Component({
	name: "PolarChartComponent"
})
export default class PolarChartComponent extends Vue {
	@Prop()
	private data: any;

	private async mounted(): Promise<void> {
		const chartCanvas = this.$refs.chart as any;
		const ctx = chartCanvas.getContext("2d");

		new Chart(ctx, {
			type: "polarArea",
			data: {
				labels: ['% довольных практическими навыками', '% усвоение программы',
                '% преп. h-Scopus > 2', 'Ср. балл', '%преп. с высоким студ.рейтингом',
                'Работа по специальности' ],
				datasets: [
					{
						data: [
            this.data.demand_skills,
            this.data.excellent,
            this.data.hirsch,
            this.data.program_value,
            this.data.teachstudentrating,
            this.data.work_value,
            ],
						backgroundColor: [
              "green",
              "black",
              "yelow",
              "violet",
              "rgba(150, 150, 33, 0.2)",
              "rgba(150, 150, 150, 0.2)",
            ],
						borderColor: [],
						borderWidth: 1
					}
				]
			},
			options: {
				scales: {
					yAxes: [
						{
							ticks: {
								beginAtZero: true
							}
						}
					]
				},
				maintainAspectRatio: false,
				legend: {
					display: false
				}
			}
		});
	}
}
</script>

<style scoped lang="scss">
.chart-component {
	display: flex;
	flex-direction: column;

	.score-data {
		display: flex;
		align-items: center;
		height: 20px;

		.score {
			border-radius: 50%;
			background: #6bcb97;
			color: #fff;
			/*width: 35px;*/
			/*height: 35px;*/
			padding: 7px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.label {
			font-size: 18px;
			line-height: 21px;
			margin-left: 12px;
		}
	}

	.chart {
		margin-top: 10px;
	}
}
</style>
