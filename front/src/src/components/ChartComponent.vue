<template>
	<div class="chart-component">
		<div class="score-data">
		<div class="score" :style="`background: ${getScoreColor(data.score)}`">
			{{ data.score }}
		</div>
			<div class="label">{{ data.title }}</div>
		</div>

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
import {ScoreColorsEnum} from "@/models/ScoreColorsModel";


@Component({
	name: "ChartComponent"
})
export default class ChartComponent extends Vue {
	@Prop()
	private data: any;

	private async mounted(): Promise<void> {
		const chartCanvas = this.$refs.chart as any;
		const ctx = chartCanvas.getContext("2d");

		const years = this.data.data.map((v: any) => v.year);
		const avg = this.data.data.map((v: any) => parseFloat(v.value));
		const colors = this.data.data.map((v: any) => v.color_func(parseFloat(v.value)));

		new Chart(ctx, {
			type: "bar",
			data: {
				labels: years,
				datasets: [
					{
						data: avg,
						backgroundColor: colors.map((color: any) =>
							color.replace(/#{opacity}/, "0.2")
						),
						borderColor: colors.map((color: any) => color.replace(/#{opacity}/, "1")),
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
      private getScoreColor(score: number): string {
    		if (score > -1 && score < 3) return ScoreColorsEnum.CRITICAL;
    		if (score >= 3 && score < 8) return ScoreColorsEnum.WARN;
    		if (score > 8 && score < 10) return ScoreColorsEnum.OK;

    		return "";
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
			width: 35px;
			height: 35px;
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
