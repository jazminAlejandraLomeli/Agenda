import axios from "axios";

export const requestDeny = async (id, reason) => {
    return new Promise(async (resolve, reject) => {
        try {
            const Data = {
                id: parseInt(id),
                reason,
            };

            console.log(Data);
            const { status } = await axios.post(`/agenda/deny-classroom`, Data);

            console.log(status);

            if (status === 204) {
                resolve({
                    title: "¡Éxito!",
                    message:
                        "La reservación se se elimino del sistema correctamente y se envío correo con el motivo.",
                });
            }
        } catch (error) {
            const { status } = error;
            reject(error);
        }
    });
};
