<template>
	<nav>
		<img src="../assets/img/logo.svg" alt="logo" class="logo" />

		<ul>
			<li>
				<router-link :to="{ name: 'Programs' }" class="menu-item" exact>
					<i class="material-icons icon">poll</i>
					<span class="label">Обзор программ</span>
				</router-link>
			</li>

			<li>
				<router-link :to="{ name: 'Teacher' }" class="menu-item">
					<i class="material-icons icon">person</i>
					<span class="label">Препода - ватель</span>
				</router-link>
			</li>

			<li class="pushed">
				<router-link :to="{ name: 'Parameters' }" class="menu-item">
					<i class="material-icons icon">settings</i>
					<span class="label">Параметры</span>
				</router-link>
			</li>
		</ul>
	</nav>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

@Component({
	name: "SideBar"
})
export default class SideBar extends Vue {}
</script>

<style scoped lang="scss">
nav {
	background: #07a4fc;
	width: 90px;
	height: 100vh;
	position: fixed;
	padding-right: 1px;

	.logo {
		width: 70%;
		display: block;
		margin: 10px auto;
	}

	ul {
		display: flex;
		flex-direction: column;
		height: 100vh;

		li.pushed {
			margin: auto 0 100px;
		}

		.menu-item {
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
			color: #fff;
			opacity: 0.7;
			margin-top: 40px;
			cursor: pointer;

			&.router-link-active {
				opacity: 1;
				border-right: 3px solid #fff;
			}

			.icon {
				font-size: 40px;
			}

			.label {
				margin-top: 8px;
				font-size: 14px;
			}
		}
	}
}
</style>
