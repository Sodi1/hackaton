<template>
	<div class="parameters-card">
		<div class="title">Параметры</div>

		<div class="input-group">
			<div class="label">Средний балл по специальности: {{ parameters.avgProgramScore }}</div>
			<input type="range" min="0.5" max="1" step="0.1" v-model="parameters.avgProgramScore" />
		</div>

		<div class="input-group">
			<div class="label">Работа по специальности: {{ parameters.workInTheSpecialty }}</div>
			<input
				type="range"
				min="0.5"
				max="1"
				step="0.1"
				v-model="parameters.workInTheSpecialty"
			/>
		</div>

		<div class="input-group">
			<div class="label">
				% довольных практическими навыками: {{ parameters.satisfiedWithPracticalSkills }}
			</div>
			<input
				type="range"
				min="0.5"
				max="1"
				step="0.1"
				v-model="parameters.satisfiedWithPracticalSkills"
			/>
		</div>

		<div class="input-group">
			<div class="label">% освоение программы: {{ parameters.masteringProgram }}</div>
			<input
				type="range"
				min="0.5"
				max="1"
				step="0.1"
				v-model="parameters.masteringProgram"
			/>
		</div>

		<div class="input-group">
			<div class="label">
				% преп. с высокми студ. рейтингом: {{ parameters.teacherWithHighScore }}
			</div>
			<input
				type="range"
				min="0.5"
				max="1"
				step="0.1"
				v-model="parameters.teacherWithHighScore"
			/>
		</div>

		<div class="input-group">
			<div class="label">
				% преп. h-Scopus > 2: {{ parameters.hirsch }}
			</div>
			<input
				type="range"
				min="0.5"
				max="1"
				step="0.1"
				v-model="parameters.hirsch"
			/>
		</div>

		<div class="btn" @click="saveParametersHandler">Применить</div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component({
	name: "ParameterView"
})
export default class ParameterView extends Vue {
	private parameters = {
		avgProgramScore: 0.8,
		workInTheSpecialty: 0.6,
		satisfiedWithPracticalSkills: 0.5,
		masteringProgram: 0.7,
		teacherWithHighScore: 0.6,
    hirsch: 0.5
	};

	private mounted(): void {
		const parametersString = localStorage.getItem("parameters");

		if (parametersString) {
			this.parameters = JSON.parse(parametersString);
		} else {
			localStorage.setItem("parameters", JSON.stringify(this.parameters));
		}
	}

	private saveParametersHandler(): void {
		localStorage.setItem("parameters", JSON.stringify(this.parameters));
		this.$router.push({ name: "Programs" });
    location.reload();
	}
}
</script>

<style scoped lang="scss">
.parameters-card {
	border: 2px solid #eaeaea;
	margin: 0 auto;
	display: flex;
	flex-direction: column;
	align-items: center;
	width: 35%;
	background: #fff;
	padding: 30px 60px;

	.title {
		font-size: 24px;
		line-height: 28px;
		text-align: center;
		margin-bottom: 30px;
	}

	.input-group {
		margin-bottom: 30px;
		width: 100%;

		.label {
			font-size: 18px;
		}

		input {
			width: 100%;
			margin-top: 8px;
		}
	}

	.btn {
		padding: 7px 14px;
		background: #07a4fc;
		color: #fff;
		display: block;
		cursor: pointer;
	}
}
</style>
