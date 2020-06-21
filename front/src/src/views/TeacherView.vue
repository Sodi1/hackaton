<template>
	<div class="teacher-card">
		<div class="teacher-data">
			<img class="avatar" src="../assets/img/avatar.jpg" />

			<div class="info">
				<div class="name">{{ teacherName }}</div>
				<span class="position">{{ teacherPosition }}</span>
				<span class="email">{{ teacherName && "i.kovalev@stankin.ru" }}</span>
				<div class="rating">Рейтинг <span>47</span></div>
			</div>

			<div class="badges">
				<div class="tooltip">
					<img src="../assets/img/badges/badge1.png" alt="badge1" />
					<span class="tooltip-text">цитируемый автор</span>
				</div>

				<div class="tooltip">
					<img src="../assets/img/badges/badge2.png" alt="badge2" />
					<span class="tooltip-text">патентообладатель</span>
				</div>

				<div class="tooltip">
					<img src="../assets/img/badges/badge3.png" alt="badge3" class="inactive" />
					<span class="tooltip-text">ментор</span>
				</div>

				<div class="tooltip">
					<img src="../assets/img/badges/badge4.png" alt="badge4" />
					<span class="tooltip-text">грантополучатель</span>
				</div>
			</div>
		</div>

		<VueGoodTable
			v-if="tableData && tableData.length"
			styleClass="vgt-table bordered table"
			:columns="tableColumns"
			:rows="tableData"
			:sort-options="{ enabled: false }"
		>
		</VueGoodTable>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import TeacherApiService from "@/service/TeacherApiService";

@Component({
	name: "TeacherView",
	components: { VueGoodTable }
})
export default class TeacherView extends Vue {
	private teacherApiService: TeacherApiService = new TeacherApiService();
	private teacherName = "";
	private teacherPosition = "";

	private tableColumns = [
		{
			label: "Год",
			field: "year"
		},
		{
			label: "Индекс Хирша",
			field: "hirschIndex"
		},
		{
			label: "Рейтинг ППС",
			field: "ratingPpc"
		},
		{
			label: "Рейтинг от студентов",
			field: "ratingStudent"
		},
		{
			label: "Работающий практик",
			field: "practices"
		}
	];

	private tableData: any[] = [];

	private async mounted(): Promise<void> {
		let teacherData = await this.teacherApiService.findTeacher("56496427500");
		this.teacherName = teacherData[0].full_name;

		teacherData = teacherData.sort((a, b) => parseInt(b.year) - parseInt(a.year));
		this.teacherPosition = teacherData[0].position;

		teacherData.forEach((record: any) => {
			this.tableData.push({
				year: record.year,
				hirschIndex: record.hirsch_index,
				ratingPpc: record.rating_ppc,
				ratingStudent: record.rating_student,
				practices: record.practices
			});
		});
	}
}
</script>

<style scoped lang="scss">
.teacher-card {
	border: 2px solid #eaeaea;
	display: block;
	width: 70%;
	margin: 20px auto;
	background: #fff;
	padding: 20px 50px 20px;

	.teacher-data {
		display: flex;

		.avatar {
			width: 150px;
		}

		.info {
			margin-left: 20px;

			.name {
				font-size: 30px;
				line-height: 35px;
				margin-bottom: 5px;
			}

			.position {
				font-family: "Roboto Light", sans-serif;
				font-size: 18px;
			}

			.email {
				font-family: "Roboto Light", sans-serif;
				font-size: 18px;
				line-height: 21px;
				color: #9e9e9e;
				margin-left: 10px;
			}

			.rating {
				margin-top: 20px;
				font-size: 20px;

				span {
					color: #07a4fc;
				}
			}
		}

		.badges {
			margin-left: auto;

			img.inactive {
				opacity: 0.4;
			}

			img {
				width: 35px;
				height: 35px;
				margin-right: 15px;
				margin-top: 5px;
			}

			.tooltip {
				position: relative;
				display: inline-block;
			}

			.tooltip .tooltip-text {
				visibility: hidden;
				width: 160px;
				background-color: black;
				color: #fff;
				text-align: center;
				padding: 5px 0;
				border-radius: 3px;

				position: absolute;
				z-index: 1;

				bottom: 105%;
				left: 50%;
				margin-left: -87.5px;
			}

			.tooltip .tooltip-text::after {
				content: " ";
				position: absolute;
				top: 100%;
				left: 50%;
				margin-left: -5px;
				border-width: 5px;
				border-style: solid;
				border-color: black transparent transparent transparent;
			}

			.tooltip:hover .tooltip-text {
				visibility: visible;
			}
		}
	}
}
</style>

<style>
.teacher-card .table {
	margin-top: 30px;
}
</style>
