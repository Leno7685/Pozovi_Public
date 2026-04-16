function enableRowEdit(button) {
    document.getElementById("btnSaveChanges").style.display = 'block';
    const row = button.closest("tr");
    const cells = row.querySelectorAll("td");

    const name = cells[0].innerText;
    cells[0].innerHTML = `<input type="text" name="name[]" class="form-control" minlength="2" maxlength="50" value="${name}">`;

    const email = cells[1].innerText;
    cells[1].innerHTML = `<input type="email" name="email[]" class="form-control" maxlength="254" value="${email}">`;

    const attendance = cells[2].innerText;
    cells[2].innerHTML = `<input type="text" class="form-control" disabled value="${attendance}">`;

    const createdAt = cells[3].innerText;
    cells[3].innerHTML = `<input type="text" class="form-control" disabled value="${createdAt}">`;

    button.style.display = "none";

    const inviteeId = row.getAttribute("data-invitee-id");
    row.insertAdjacentHTML('beforeend', `<input type="hidden" name="edited_ids[]" value="${inviteeId}">`);
}

const deletedInvitees = [];

function deleteInviteeRow(button) {
    document.getElementById("btnSaveChanges").style.display = 'block';
    const row = button.closest("tr");
    const inviteeId = row.getAttribute("data-invitee-id");
    deletedInvitees.push(inviteeId);
    row.remove();

    document.getElementById("deleted_invitees_input").value = JSON.stringify(deletedInvitees);
}
