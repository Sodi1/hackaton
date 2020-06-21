<template>
	<div class="card-blocks">
		<ProgramsCardComponent @changeSelectedProgram="changeSelectedProgramHandler" />

		<SelectedProgramView :selected-program="currentlySelectedProgram" />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import SelectedProgramView from "@/components/SelectedProgramView.vue";
import ProgramsCardComponent from "@/components/ProgramsCardComponent.vue";
import ProgramModel from "@/models/ProgramModel";

@Component({
	name: "ProgramsView",
	components: { ProgramsCardComponent, SelectedProgramView }
})
export default class ProgramsView extends Vue {
	private currentlySelectedProgram: ProgramModel | null = null;

	private changeSelectedProgramHandler(program: ProgramModel): void {
		this.currentlySelectedProgram = program;
	}
	private beforeCreate(): void {
		const parametersString = localStorage.getItem("parameters");

		if (parametersString) {
      1
		} else {
      localStorage.setItem("parameters", '{"avgProgramScore":0.8,"workInTheSpecialty":0.6,"satisfiedWithPracticalSkills":0.5,"masteringProgram":0.7,"teacherWithHighScore":0.6,"hirsch":0.5}');
		}

	}
}
</script>

<style scoped lang="scss">
.card-blocks {
	display: flex;
}
</style>
