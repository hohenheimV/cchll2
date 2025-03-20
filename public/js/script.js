function swalSuccess(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'success',
        confirmButtonText: 'Great',
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
            console.log('Modal closed');
        }
    });
}

function swalLoad(message){
    Swal.fire({
        title: 'Makluman',
        text: message,
        icon: 'info',
        confirmButtonText: 'Great',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
            console.log('Modal closed');
        }
    });
}