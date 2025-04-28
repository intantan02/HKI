document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.querySelector("tbody");
    const searchInput = document.getElementById("searchInput");

    // Fungsi untuk render data ke tabel
    function renderTable(data) {
        tbody.innerHTML = "";
        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7">Tidak ada data</td></tr>`;
            return;
        }
        data.forEach(row => {
            const tr = document.createElement("tr");
            tr.classList.add("bg-white");
            tr.innerHTML = `
                <td>${row.judul}</td>
                <td><a href="uploads/${row.file_ktp}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                <td><a href="uploads/${row.file_contoh_karya}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                <td><a href="uploads/${row.file_sp}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                <td><a href="uploads/${row.file_sph}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                <td>-</td>
                <td>-</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Ambil data dari backend
    async function fetchData() {
        try {
            const response = await fetch("data.php");
            if (!response.ok) throw new Error("Gagal mengambil data");
            const data = await response.json();
            renderTable(data);
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="7">Gagal memuat data</td></tr>`;
            console.error(error);
        }
    }

    // Filter pencarian
    searchInput.addEventListener("input", () => {
        const filter = searchInput.value.toLowerCase();
        const rows = tbody.querySelectorAll("tr");
        rows.forEach(row => {
            const judul = row.querySelector("td")?.textContent.toLowerCase() || "";
            row.style.display = judul.includes(filter) ? "" : "none";
        });
    });

    fetchData();
});
