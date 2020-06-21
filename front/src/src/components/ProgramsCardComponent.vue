<template>
	<section class="programs-card">
		<div class="title">ФГОС ВО</div>

		<div v-if="!isProgramsLoading">
			<ProgramTileComponent
				v-for="(program, index) in programs"
				:key="index"
				:program="program"
				@click="$emit('changeSelectedProgram', $event)"
			/>
		</div>

		<LoaderComponent v-else />
	</section>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import ProgramTileComponent from "@/components/ProgramTileComponent.vue";
import ProgramModel from "@/models/ProgramModel";
import ProgramApiService from "@/service/ProgramApiService";
import LoaderComponent from "@/components/LoaderComponent.vue";

@Component({
	name: "ProgramsCardComponent",
	components: { LoaderComponent, ProgramTileComponent }
})
export default class ProgramsCardComponent extends Vue {
	private programs: ProgramModel[] = [];

	private programApiService: ProgramApiService = new ProgramApiService();

	private isProgramsLoading = false;

	private async mounted(): Promise<void> {
		this.isProgramsLoading = true;
		this.programs = await this.programApiService.getAllPrograms();

		this.programs = this.programs.sort((a, _) => {
			if (a.code === "15.04.04" || a.code === "15.03.04") return -1;

			return 1;
		});

		this.isProgramsLoading = false;
	}
}
</script>

<style scoped lang="scss">
.programs-card {
	border: 2px solid #eaeaea;
	margin-left: 2%;
	display: inline-block;
	width: 30%;
	background: #fff;

	.title {
		font-size: 24px;
		line-height: 28px;
		text-align: center;
		margin: 30px 0;
	}
}
</style>
