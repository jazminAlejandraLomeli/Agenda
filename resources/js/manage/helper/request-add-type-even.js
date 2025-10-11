import axios from "axios";

export const requestAddEventType = async (Id, Group, name) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                
                Grupo: parseInt(Group),
                Nombre: name,
            };

            const { status } = await axios.post(
                `/agenda/event-types/store`,
                Data
            );
            if (status === 200) {

                resolve({
                    title: "¡Éxito!",
                    message: "Tipo de evento creado correctamente.",
                });
            }

            reject({
                title: "¡Error!",
                message: "Hubo un error al actualiazar el dato.",
            });
        } catch (error) {
            reject(error);
        }
    });
};
