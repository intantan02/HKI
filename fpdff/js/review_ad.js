document.addEventListener("DOMContentLoaded", function () {
    const permohonanTable = document.getElementById("permohonanTable");
    const searchInput = document.getElementById("searchInput");

    // Ambil data dari backend
    fetch("review_ad_backend.php")
        .then((response) => response.json())
        .then((result) => {
            if (!result.success) {
                alert("Gagal memuat data: " + result.message);
                return;
            }

            const data = result.data;
            permohonanTable.innerHTML = data.map((row) => `
                <tr>
                    <td>${row.judul}</td>
                    <td><a href="uploads/${row.file_ktp}" target="_blank">Unduh</a></td>
                    <td><a href="uploads/${row.file_contoh_karya}" target="_blank">Unduh</a></td>
                    <td><a href="uploads/${row.file_bukti_pembayaran}" target="_blank">Unduh</a></td>
                    <td><a href="uploads/${row.file_sp}" target="_blank">Unduh</a></td>
                    <td><a href="uploads/${row.file_sph}" target="_blank">Unduh</a></td>
                    <td>
                        <form method="POST" enctype="multipart/form-data" class="form-upload">
                            <input type="hidden" name="id" value="${row.id}">
                            <select name="status" class="form-select">
                                <option value="Diajukan" ${row.status === 'Diajukan' ? 'selected' : ''}>Diajukan</option>
                                <option value="Revisi" ${row.status === 'Revisi' ? 'selected' : ''}>Revisi</option>
                                <option value="Terdaftar" ${row.status === 'Terdaftar' ? 'selected' : ''}>Terdaftar</option>
                            </select>
                            <input type="file" name="sertifikat" class="form-control">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </td>
                    <td>
                        ${row.status ? `<span class="badge badge-${row.status.toLowerCase()}">${row.status}</span>` : '<span class="text-muted">Belum diatur</span>'}
                    </td>
                    <td>
                        ${row.sertifikat ? `<a href="${row.sertifikat}" target="_blank">Unduh</a>` : '<span class="text-muted">Belum tersedia</span>'}
                    </td>
                </tr>
            `).join("");

            // Filter pencarian
            searchInput.addEventListener("input", function () {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll("#permohonanTable tr");

                rows.forEach(row => {
                    const judul = row.querySelector("td")?.textContent.toLowerCase();
                    row.style.display = judul.includes(filter) ? "" : "none";
                });
            });
        })
        .catch((error) => console.error("Error:", error));
});