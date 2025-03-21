function swalSuccess(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'success',
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
        }
    });
}

function swalLoad(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'info',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
        }
    });
}

function swalError(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'error',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
        }
    });
}

function swalWarning(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'warning',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
        }
    });
}

function swalQuestion(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'question',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
        }
    });
}