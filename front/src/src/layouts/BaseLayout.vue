<template>
	<div class="base-layout">
		<SideBar />

		<main>
			<slot />
		</main>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import SideBar from "@/layouts/SideBar.vue";

@Component({
	name: "BaseLayout",
	components: { SideBar }
})
export default class BaseLayout extends Vue {}
</script>

<style scoped lang="scss">
main {
	margin-left: 90px;
	padding: 1.5% 0;
}
</style>
