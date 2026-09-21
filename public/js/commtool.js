
// Formatear numero E.EEE,DD
function formatear_numero(num) {
    let fnum=parseFloat(num).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    return fnum;
}

// Formatear numero EEEE.DD
function formatear_numero_input(num) {

    return parseFloat(num).toFixed(0);
}
