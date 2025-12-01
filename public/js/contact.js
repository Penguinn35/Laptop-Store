document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("contactsTable");

    // Mark Read
    table.addEventListener("click", async function (e) {
        if (e.target.classList.contains("mark-read")) {
            const row = e.target.closest("tr");
            const id = row.dataset.id;

            const res = await fetch(`/laptop_store/public/index.php?page=contact_mark_ajax`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: id, status: "read" })
            });

            const data = await res.json();
            if (data.success) {
                row.querySelector(".status-cell").textContent = "read";
                row.classList.add("row-read");
            }
        }
    });

    // Delete Row
    table.addEventListener("click", async function (e) {
        if (e.target.classList.contains("delete-contact")) {
            const row = e.target.closest("tr");
            const id = row.dataset.id;

            if (!confirm("Bạn có chắc muốn xoá?")) return;

            const res = await fetch(`/laptop_store/public/index.php?page=contact_delete_ajax`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: id })
            });

            const data = await res.json();
            if (data.success) {
                row.remove();
            }
        }
    });

});
