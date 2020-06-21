import httpClient from "@/service/http.client";

export default class TeacherApiService {
	private API_ENDPOINT = "teacher";

	public async findTeacher(scopusId: string): Promise<any> {
		const response = await httpClient().get(
			`${this.API_ENDPOINT}/find.php?scopusid=${scopusId}`
		);

		return response.data.records;
	}
}
