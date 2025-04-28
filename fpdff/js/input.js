document.addEventListener("DOMContentLoaded", function () {
    const pengusulList = document.getElementById("pengusul-list");

    // Fetch data pengusul
    fetch("../Backend/input_backend.php?dataid=" + new URLSearchParams(window.location.search).get("dataid"))
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                data.data.forEach((row) => {
                    const div = document.createElement("div");
                    div.className = "bg-white p-4 rounded-lg shadow";
                    div.innerHTML = `
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold">${row.Nama}</h2>
                                <p class="text-gray-600">${row.Alamat}, ${row.Kode_Pos}</p>
                                <p class="text-gray-600">📞 ${row.Nomor_Telepon}</p>
                                <p class="text-gray-600">✉ ${row.Email}</p>
                                <p class="text-gray-600">🏫 ${row.Fakultas}</p>
                                <span class="bg-blue-600 text-white px-2 py-1 rounded-full text-sm">${row.role}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="edit.php?id=${row.id}&role=${row.role}&dataid=${dataid}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></a>
                                <a href="#" class="text-red-500 hover:text-red-700" onclick="deletePengusul(${row.id}, '${row.role}')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    `;
                    pengusulList.appendChild(div);
                });
            } else {
                pengusulList.innerHTML = `<p class="text-gray-600 text-center">Belum ada data pengusul ditambahkan.</p>`;
            }
        })
        .catch((error) => console.error("Error:", error));
});

function deletePengusul(id, role) {
    if (confirm("Yakin ingin menghapus?")) {
        fetch("input_backend.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ delete_id: id, role: role }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => console.error("Error:", error));
    }
}