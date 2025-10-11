/* Expresiones regulares para validar los datos */

export const regexNumero = /^(?=.*\d)/;
export const regexLetters = /^[a-zA-ZáÁéÉíÍóÓúÚÑñ."\- ]+$/;
export const regexText = /^[a-zA-ZáÁéÉíÍóÓúÚÑñ0-9\s.,;:?!'/"\-()]+$/;


export const regexPassword =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=])(.{4,13})$/;

export const regexCode = /^[0-9]{7,9}$/;
export const regexDiseasesName = /^[a-zA-ZáÁéÉíÍóÓúÚÑñ0-9\s.\-()]+$/;

export const regexFecha = /^\d{4}-\d{2}-\d{2}$/;
export const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
export const regexDecimal = /^(?=.*\d)(?:\d*\.\d+|\d+)$/;
export const regexTelefono = /^[0-9]{10}$/;
export const regexNumbersAndLetters = /^[a-zA-Z0-9]+$/;

export const regexCedula = /^[0-9]{7,8}$/;
export const regexNss = /^[0-9]{11}$/;

export const regexNumeroEntero = /^\d+$/;
export const regexNumlenght2 = /^[0-9]{1,2}$/;
export const regexAnio = /^[0-9]{4}$/;
export const regexCp = /^[0-9]{5}$/;

export const regexFrecuenciaCardiaca =
    /^(3[0-9]|[4-9][0-9]|1[0-9]{2}|2[0-1][0-9]|220)$/;
export const regexPresionArterial =
    /^(9[0-9]|1[0-9]{2}|2[0-4][0-9]|250)\/([6-9][0-9]|1[0-3][0-9]|140)$/;
export const regexTemperatura = /^(3[5-9](\.\d)?|4[0-1](\.\d)?|42(\.0)?)$/;
export const regexPesoKilogramos = /^(?:[1-9][0-9]{0,2}|300)(?:\.\d{1,2})?$/;
export const regexFrecuenciaRespiratoria = /^(1[0-9]|[2-5][0-9]|60)$/;
export const regexPorcentaje = /^(100|[1-9][0-9]?|0)$/;
export const regexGlucosa = /^(?:[1-9][0-9]?|[1-3][0-9]{2}|400)$/;

export const RegexPositiveNumer = /^[0-9]\d*$/;
