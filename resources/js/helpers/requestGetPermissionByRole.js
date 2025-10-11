import axios from "axios"
import { showLoader, hideLoader } from "./loader.js";

export const requestGetPermissionByRole = async (role, group) => {
    return new Promise(async (resolve, reject) => {
        showLoader('Obteniendo los permisos del rol');
        try {
            let groupUrl = group == '' ? '' : `/${group}`
            const response = await axios.get(`/agenda/api/get-permission/${role}${groupUrl}`);

            if (response.status === 200) {
                resolve(response.data);
            }

            reject({
                title: 'Error!',
                message: 'Hubo un error al obtener los permisos del rol'
            });



        } catch (error) {
            console.error(error);
            reject(error);
        } finally {
            hideLoader();
        }






    });

}