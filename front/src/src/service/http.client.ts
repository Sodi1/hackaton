import axios from "axios";

const httpClient = () => {
	const headers: any = {
		"Content-Type": "application/json"
	};

	return axios.create({
		baseURL: process.env.VUE_APP_API_HOST,
		headers
	});
};

export default httpClient;
