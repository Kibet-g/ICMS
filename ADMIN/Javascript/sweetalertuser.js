function confirmUpdate(id_number, email, name, idtype, mobile_no) {
    Swal.fire({
        title: 'Update Confirmation',
        text: "Do you want to update the details?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            showUpdateForm(id_number, email, name, idtype, mobile_no);
        }
    });
}

function showUpdateForm(id_number, email, name, idtype, mobile_no) {
    document.getElementById('updateIdNumber').value = id_number;
    document.getElementById('updateEmail').value = email;
    document.getElementById('updateName').value = name;
    document.getElementById('updateIdType').value = idtype;
    document.getElementById('updateMobileNo').value = mobile_no;
    document.getElementById('updateFormContainer').style.display = "flex";
}

function confirmDelete(event, id_number) {
    event.preventDefault();  // Prevent the form from submitting immediately
    Swal.fire({
        title: 'Delete Confirmation',
        text: "Are you sure you want to delete this record?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm_' + id_number).submit();
        }
    });
}

function closeUpdateForm() {
    document.getElementById('updateFormContainer').style.display = "none";
}

function closeDeleteForm() {
    document.getElementById('deleteFormContainer').style.display = "none";
}
