/**
 * assets/js/crud.js
 * Modul 08 - Web Programming 1
 * Fitur: Validasi Form Client-Side, Search/Filter Real-Time, Confirm Delete, & Alert Feedback
 */

document.addEventListener("DOMContentLoaded", function () {
    // 1. Validasi Client-Side Form CRUD (Step 8)
    const form = document.querySelector("[data-crud-form]");
    if (form) {
        form.addEventListener("submit", function (event) {
            const nim = document.getElementById("nim");
            const nama = document.getElementById("nama");
            const prodi = document.getElementById("program_studi");
            const email = document.getElementById("email");
            let valid = true;

            // Reset pesan error dan class visual invalid
            document.querySelectorAll(".form-error").forEach(function (el) {
                el.textContent = "";
            });
            document.querySelectorAll(".is-invalid").forEach(function (el) {
                el.classList.remove("is-invalid");
            });

            // Validasi NIM
            if (nim && nim.value.trim() === "") {
                const errNim = document.getElementById("errorNim");
                if (errNim) errNim.textContent = "NIM wajib diisi.";
                nim.classList.add("is-invalid");
                valid = false;
            }

            // Validasi Nama
            if (nama && nama.value.trim() === "") {
                const errNama = document.getElementById("errorNama");
                if (errNama) errNama.textContent = "Nama wajib diisi.";
                nama.classList.add("is-invalid");
                valid = false;
            }

            // Validasi Program Studi
            if (prodi && prodi.value.trim() === "") {
                const errProdi = document.getElementById("errorProdi");
                if (errProdi) errProdi.textContent = "Program studi wajib diisi.";
                prodi.classList.add("is-invalid");
                valid = false;
            }

            // Validasi Format Email
            if (email && (email.value.trim() === "" || !email.checkValidity())) {
                const errEmail = document.getElementById("errorEmail");
                if (errEmail) errEmail.textContent = "Email wajib menggunakan format yang valid.";
                email.classList.add("is-invalid");
                valid = false;
            }

            // Jika ada field tidak valid, batalkan submit dan beri notifikasi
            if (!valid) {
                event.preventDefault();
                alert("Form belum valid. Periksa kembali data Anda.");
            }
        });
    }

    // 2. Konfirmasi Hapus Data / Friction on Delete (Step 13)
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach(function (delForm) {
        delForm.addEventListener("submit", function (event) {
            const yakin = confirm("Yakin ingin menghapus data ini?");
            if (!yakin) {
                event.preventDefault();
            }
        });
    });

    // 3. Search / Filter Tabel Mahasiswa (Step 14)
    const searchInput = document.getElementById("searchMahasiswa");
    const tableRows = document.querySelectorAll("#crudTable tbody tr");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const keyword = searchInput.value.toLowerCase().trim();
            tableRows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        });
    }

    // 4. Feedback Alert Berdasarkan Status URL Query (Step 15)
    const params = new URLSearchParams(window.location.search);
    const status = params.get("status");
    if (status === "tambah") {
        alert("Data berhasil ditambahkan.");
    }
    if (status === "update") {
        alert("Data berhasil diperbarui.");
    }
    if (status === "hapus") {
        alert("Data berhasil dihapus.");
    }
});
