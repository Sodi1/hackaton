<template>
	<div id="app">
		<BaseLayout>
			<keep-alive>
				<router-view />
			</keep-alive>
		</BaseLayout>
	</div>
</template>

<style lang="scss">
@import "assets/css/common";
</style>

<script>
import { Vue, Component } from "vue-property-decorator";
import BaseLayout from "@/layouts/BaseLayout";
@Component({
	components: { BaseLayout }
})
export default class App extends Vue {}
</script>
