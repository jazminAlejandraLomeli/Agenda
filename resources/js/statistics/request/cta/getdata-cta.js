import axios from "axios";
import { hideLoader } from "../../../helpers/loader";

export const request_cta_data = async (data) => {
    try {
        const response = await axios.get(
            "/agenda/statistics/events-get-data-cta",
            {
                params: data,
            }
        );
        return response.data[0];
    } catch (error) {
        throw {
            title: "Error!",
            message: "Hubo un error al obtener los datos",
        };
    } finally {
        hideLoader();
    }
};
