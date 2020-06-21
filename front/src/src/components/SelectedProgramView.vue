<template>
	<section class="selected-program" v-if="selectedProgram">
		<div class="program-title">
			<div class="code">{{ selectedProgram.code }}</div>
			<div class="name">{{ selectedProgram.name }}</div>
		</div>

		<div class="action-buttons">
			<div class="btn all">Все</div>
			<div class="btn warning">Предупреждения</div>
			<div class="btn critical">Критические</div>
		</div>

		<div class="date-pickers">
			<div class="picker">
				<div class="picker-label">От</div>
				<DatePicker type="year" v-model="filterStartYear" :editable="false" />
			</div>

			<div class="picker">
				<div class="picker-label">До</div>
				<DatePicker
					type="year"
					v-model="filterEndYear"
					:editable="false"
					:disabled="!filterStartYear"
					:disabled-date="notBeforeStartYear"
				/>
			</div>
		</div>

		<div class="charts" v-if="chartData">
			<ChartComponent v-for="(data, index) in chartData" :key="index" :data="data" />
		</div>

		<div class="charts" v-if="ScoreData">
			<PolarChartComponent v-for="(data, index) in ScoreData" :key="index" :data="data" />
		</div>

		<LoaderComponent v-else style="margin-top: 30px" />
	</section>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from "vue-property-decorator";
import ChartComponent from "@/components/ChartComponent.vue";
import PolarChartComponent from "@/components/PolarChartComponent.vue";
import ProgramModel from "@/models/ProgramModel";
import DatePicker from "vue2-datepicker";
import ProgramApiService from "@/service/ProgramApiService";
import LoaderComponent from "@/components/LoaderComponent.vue";

@Component({
	name: "SelectedProgramView",
	components: { LoaderComponent, ChartComponent, DatePicker, PolarChartComponent }
})
export default class SelectedProgramView extends Vue {
	@Prop()
	private selectedProgram: ProgramModel | undefined;

	private programApiService: ProgramApiService = new ProgramApiService();

	private filterStartYear: Date | null = null;
	private filterEndYear: Date | null = null;

	private chartData: any = null;
	private ScoreData: any = null;

	private notBeforeStartYear(date: Date) {
		return date <= this.filterStartYear;
	}

	private async fetchProgramsStatistics(years: string[]): Promise<any> {
		this.chartData = null;
		return await this.programApiService.getProgramAllStatistics(
			this.selectedProgram.code,
			years
		);
	}

	@Watch("filterStartYear")
	@Watch("filterEndYear")
	private async filterYearChanged() {
		if (this.filterStartYear && this.filterEndYear) {
			const startYear = this.filterStartYear.getFullYear();
			const endYear = this.filterEndYear.getFullYear();

			if (endYear > startYear) {
				const interval = [...Array(endYear - startYear + 1).keys()];
				const totalFilteredYears = interval.map(el => (startYear + el).toString());

				this.chartData = await this.fetchProgramsStatistics(totalFilteredYears);
			}
		}
	}

	@Watch("selectedProgram")
	private async selectedProgramWatcher(): Promise<void> {
		if (this.selectedProgram && this.selectedProgram.code) {
			this.chartData = await this.fetchProgramsStatistics(["2017", "2018", "2019"]);
			this.chartData = await this.programApiService.getProgramAllStatistics(
				this.selectedProgram.code,
				["2017", "2018", "2019"]
			);
			this.ScoreData = await this.programApiService.getProgramReports(
				this.selectedProgram.code
			);
		}
	}
}
</script>

<style scoped lang="scss">
.selected-program {
	border: 2px solid #eaeaea;
	display: inline-block;
	margin: 0 2% 0 2%;
	width: 64%;
	padding: 0 2% 2%;
	background: #fff;
	height: 100%;

	.program-title {
		margin: 30px 0;
		text-align: center;

		.code {
			font-size: 24px;
			line-height: 28px;
		}

		.name {
			font-size: 14px;
			line-height: 16px;
			color: #817f7f;
			margin-top: 8px;
		}
	}

	.action-buttons {
		display: flex;
		justify-content: center;

		.btn {
			padding: 7px 14px;
			cursor: pointer;
			color: #fff;

			&.all {
				background: #6bcb97;
			}

			&.warning {
				background: #fec401;
				margin: 0 30px;
			}

			&.critical {
				background: #dd6f4c;
			}
		}
	}

	.date-pickers {
		margin-top: 30px;
		display: flex;

		.picker {
			margin-right: 20px;
		}

		.picker-label {
			margin-bottom: 5px;
		}
	}

	.charts {
		margin-top: 40px;
		display: grid;
		grid-template-columns: repeat(3, 31%);
		column-gap: 3.5%;
		row-gap: 40px;
	}
}
</style>

<style>
.mx-datepicker input {
	border-radius: 0 !important;
}
</style>
