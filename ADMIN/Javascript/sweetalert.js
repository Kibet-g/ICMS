function confirmUpdate(policeId, policeEmail, policePhone) {
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
            showUpdateForm(policeId, policeEmail, policePhone);
        }
    });
}

function showUpdateForm(policeId, policeEmail, policePhone) {
    document.getElementById('updatePoliceId').value = policeId;
    document.getElementById('updatePoliceEmail').value = policeEmail;
    document.getElementById('updatePolicePhone').value = policePhone;
    document.getElementById('updateFormContainer').style.display = 'block';
    document.getElementById('updateFormContainer').scrollIntoView({ behavior: 'smooth' });
}

function closeUpdateForm() {
    document.getElementById('updateFormContainer').style.display = 'none';
}

function showDeleteAlert(event, policeId) {
    event.preventDefault(); // Prevent the form from submitting immediately

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
            document.getElementById('deleteForm_' + policeId).submit();
        }
    });

    return false; // Prevent the form from submitting the traditional way
}
