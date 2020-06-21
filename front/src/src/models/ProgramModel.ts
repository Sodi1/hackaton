export default class ProgramModel {
	public name: string | null = null;
	public code: string | null = null;
	public score: string = "";

	public constructor(data?: any) {
		this.name = data.name;
		this.code = data.code;
		this.score = data.score || "0";
	}
}
