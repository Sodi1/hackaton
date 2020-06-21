<template>
	<div class="loader-container">
		<div class="lds-dual-ring"></div>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component({
	name: "LoaderComponent"
})
export default class LoaderComponent extends Vue {}
</script>

<style scoped>
.loader-container {
	display: flex;
	justify-content: center;
	margin-bottom: 20px;
}

.lds-dual-ring {
	display: inline-block;
	width: 80px;
	height: 80px;
}
.lds-dual-ring:after {
	content: " ";
	display: block;
	width: 64px;
	height: 64px;
	margin: 8px;
	border-radius: 50%;
	border: 6px solid #07a4fc;
	border-color: #07a4fc transparent #07a4fc transparent;
	animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
</style>
