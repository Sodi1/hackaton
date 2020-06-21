import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
	{
		path: "/",
		name: "Programs",
		component: () => import("@/views/ProgramsView.vue")
	},
	{
		path: "/teacher",
		name: "Teacher",
		component: () => import("@/views/TeacherView.vue")
	},
	{
		path: "/parameters",
		name: "Parameters",
		component: () => import("@/views/ParameterView.vue")
	}
];

const router = new VueRouter({
	mode: "history",
	base: process.env.BASE_URL,
	routes
});

export default router;
