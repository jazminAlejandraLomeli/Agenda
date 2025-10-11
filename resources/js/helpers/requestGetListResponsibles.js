import axios from "axios"

export const requestGetListResponsibles = async (query,groupId) => {
    console.log(query,groupId);
    return new Promise(async (resolve, reject) => {
        try {
            const response = await axios.get(`/agenda/api/get-responsibles/search=${query}&group=${groupId}`);

            if (response.status === 200) {
                resolve(response.data.responsibles);
            }

            reject({
                title: 'Error!',
                message: 'Hubo un error al obtener los permisos del rol'
            });

        } catch (error) {
            console.error(error);
            reject(error);
        } 
    });

}