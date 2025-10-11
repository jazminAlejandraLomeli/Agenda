import axios from "axios";
import { hideLoader } from "../../../helpers/loader";

export const requestData = async (data) => {
     try {
       const response = await axios.get("/agenda/statistics/events-get-data", {
           params: data, 
       });
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
