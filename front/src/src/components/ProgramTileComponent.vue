<template>
	<div class="program-tile" @click="$emit('click', program)">
		<div class="program-data">
			<div class="code">{{ program.code }}</div>
			<div class="name">
				{{ program.name }}
			</div>
		</div>

		<div class="program-score" :style="`background: ${getScoreColor(program.score)}`">
			{{ program.score }}
		</div>
	</div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import ProgramModel from "@/models/ProgramModel";
import {ScoreColorsEnum} from "@/models/ScoreColorsModel";
import ProgramApiService from "@/service/ProgramApiService";

@Component({
	name: "ProgramTileComponent"
})
export default class ProgramTileComponent extends Vue {
	@Prop()
	private program: ProgramModel | undefined;
  private programApiService: ProgramApiService = new ProgramApiService();

	private async mounted(): Promise<any> {
		if (this.program) {
			this.program.score = await this.programApiService.getProgramReports(
        this.program.code
      ).then((res) => {
        let coef;
        res[0];
        coef = JSON.parse(localStorage.getItem("parameters"))


        return ((
        parseFloat(coef.avgProgramScore) * parseFloat(res[0].program_value)
        +
        parseFloat(coef.masteringProgram) * parseFloat(res[0].excellent)
        +
        parseFloat(coef.satisfiedWithPracticalSkills) * parseFloat(res[0].demand_skills)
        +
        parseFloat(coef.teacherWithHighScore) * parseFloat(res[0].teachstudentrating)
        +
        parseFloat(coef.workInTheSpecialty) * parseFloat(res[0].work_value)
        +
        parseFloat(coef.hirsch) * parseFloat(res[0].hirsch) )/47*10).toFixed(2)
      });
		}
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
.program-tile {
	padding: 7px 15px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	height: 89px;
	cursor: pointer;

	&:hover,
	&.active {
		background: #f3f3f3;
	}

	.program-data {
		width: 80%;

		.code {
			font-size: 18px;
			line-height: 21px;
		}

		.name {
			font-size: 14px;
			line-height: 16px;
			color: #817f7f;
			margin-top: 8px;
		}
	}

	.program-score {
		height: 100%;
		width: 75px;
		color: #fff;
		font-size: 24px;
		line-height: 28px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
}
</style>
