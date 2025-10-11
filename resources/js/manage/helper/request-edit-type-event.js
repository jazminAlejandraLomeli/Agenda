import axios from "axios";

export const requestEditEventType = async (Id, Group, name) => {
    return new Promise(async (resolve, reject) => {
        try {
           const Data = {
               Id: parseInt(Id),
               Grupo: parseInt(Group),
               Nombre: name,
           };
            
            console.log(Data);

            const { status } = await axios.post(
                `/agenda/event-types/update`,
                Data
            );
            if (status === 204) {

                resolve({
                    title: "¡Éxito!",
                    message: "El tipo de evento fue editado correctamente.",
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
