import axios from "axios";
import { hideLoader, showLoader } from "../../../helpers/loader";

export const request_chart_2 = async (data) => {
   
    showLoader();
    try {
        const response = await axios.get(
            "/agenda/statistics/events-labs-complete",
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
