/**
 * assets/js/media.js
 * Modul 10 - Web Programming 1
 * Fitur: Preview DOM (Foto, Audio, PDF), Validasi Client-Side File & Teks, Search Tabel Media, Confirm Delete
 */

document.addEventListener("DOMContentLoaded", function () {
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

    const form = document.querySelector("[data-media-form]");
    const fotoInput = document.getElementById("foto");
    const audioInput = document.getElementById("audio");
    const dokumenInput = document.getElementById("dokumen");

    const previewFoto = document.getElementById("previewFoto");
    const previewAudio = document.getElementById("previewAudio");
    const previewDokumen = document.getElementById("previewDokumen");

    const emptyPreviewFoto = document.getElementById("emptyPreviewFoto");
    const emptyPreviewAudio = document.getElementById("emptyPreviewAudio");

    let fotoURL = null;
    let audioURL = null;

    // 1. Preview & Validasi Foto (DOM URL.createObjectURL)
    if (fotoInput && previewFoto) {
        fotoInput.addEventListener("change", function () {
            const file = this.files[0];
            const errFoto = document.getElementById("errorFoto");
            if (errFoto) errFoto.textContent = "";
            this.classList.remove("is-invalid");

            if (!file) {
                previewFoto.hidden = true;
                previewFoto.removeAttribute("src");
                if (emptyPreviewFoto) emptyPreviewFoto.hidden = false;
                return;
            }

            if (!file.type.startsWith("image/")) {
                alert("File foto harus berupa gambar (JPG/PNG/WEBP).");
                this.value = "";
                previewFoto.hidden = true;
                previewFoto.removeAttribute("src");
                if (emptyPreviewFoto) emptyPreviewFoto.hidden = false;
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                alert("Ukuran foto maksimal 2 MB.");
                this.value = "";
                previewFoto.hidden = true;
                previewFoto.removeAttribute("src");
                if (emptyPreviewFoto) emptyPreviewFoto.hidden = false;
                return;
            }

            if (fotoURL) {
                URL.revokeObjectURL(fotoURL);
            }

            fotoURL = URL.createObjectURL(file);
            previewFoto.src = fotoURL;
            previewFoto.hidden = false;
            if (emptyPreviewFoto) emptyPreviewFoto.hidden = true;
        });
    }

    // 2. Preview & Validasi Audio
    if (audioInput && previewAudio) {
        audioInput.addEventListener("change", function () {
            const file = this.files[0];
            const errAudio = document.getElementById("errorAudio");
            if (errAudio) errAudio.textContent = "";
            this.classList.remove("is-invalid");

            if (!file) {
                previewAudio.hidden = true;
                previewAudio.removeAttribute("src");
                if (emptyPreviewAudio) emptyPreviewAudio.hidden = false;
                return;
            }

            const isAudioName = /\.(mp3|wav)$/i.test(file.name);
            if (!file.type.startsWith("audio/") && !isAudioName) {
                alert("File audio harus berupa MP3 atau WAV.");
                this.value = "";
                previewAudio.hidden = true;
                previewAudio.removeAttribute("src");
                if (emptyPreviewAudio) emptyPreviewAudio.hidden = false;
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                alert("Ukuran audio maksimal 2 MB.");
                this.value = "";
                previewAudio.hidden = true;
                previewAudio.removeAttribute("src");
                if (emptyPreviewAudio) emptyPreviewAudio.hidden = false;
                return;
            }

            if (audioURL) {
                URL.revokeObjectURL(audioURL);
            }

            audioURL = URL.createObjectURL(file);
            previewAudio.src = audioURL;
            previewAudio.hidden = false;
            if (emptyPreviewAudio) emptyPreviewAudio.hidden = true;
        });
    }

    // 3. Preview Info & Validasi Dokumen PDF
    if (dokumenInput && previewDokumen) {
        const defaultDocText = previewDokumen.textContent || "Belum ada dokumen dipilih.";

        dokumenInput.addEventListener("change", function () {
            const file = this.files[0];
            const errDokumen = document.getElementById("errorDokumen");
            if (errDokumen) errDokumen.textContent = "";
            this.classList.remove("is-invalid");

            if (!file) {
                previewDokumen.textContent = defaultDocText;
                return;
            }

            const isPdf = file.type === "application/pdf" || /\.pdf$/i.test(file.name);
            if (!isPdf) {
                alert("Dokumen harus berupa PDF.");
                this.value = "";
                previewDokumen.textContent = defaultDocText;
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                alert("Ukuran dokumen maksimal 2 MB.");
                this.value = "";
                previewDokumen.textContent = defaultDocText;
                return;
            }

            const sizeKb = Math.max(1, Math.round(file.size / 1024));
            previewDokumen.textContent = file.name + " - " + sizeKb + " KB";
        });
    }

    // 4. Validasi Submit Form CRUD Media
    if (form) {
        form.addEventListener("submit", function (event) {
            const nim = document.getElementById("nim");
            const nama = document.getElementById("nama");
            const prodi = document.getElementById("program_studi");
            const email = document.getElementById("email");

            let valid = true;

            document.querySelectorAll(".form-error").forEach(function (el) {
                el.textContent = "";
            });

            document.querySelectorAll(".is-invalid").forEach(function (el) {
                el.classList.remove("is-invalid");
            });

            if (!nim || nim.value.trim() === "") {
                const errNim = document.getElementById("errorNim");
                if (errNim) errNim.textContent = "NIM wajib diisi.";
                if (nim) nim.classList.add("is-invalid");
                valid = false;
            }

            if (!nama || nama.value.trim() === "") {
                const errNama = document.getElementById("errorNama");
                if (errNama) errNama.textContent = "Nama wajib diisi.";
                if (nama) nama.classList.add("is-invalid");
                valid = false;
            }

            if (!prodi || prodi.value.trim() === "") {
                const errProdi = document.getElementById("errorProdi");
                if (errProdi) errProdi.textContent = "Program studi wajib diisi.";
                if (prodi) prodi.classList.add("is-invalid");
                valid = false;
            }

            if (!email || email.value.trim() === "" || !email.checkValidity()) {
                const errEmail = document.getElementById("errorEmail");
                if (errEmail) errEmail.textContent = "Email tidak valid.";
                if (email) email.classList.add("is-invalid");
                valid = false;
            }

            const wajibFoto = form.dataset.requireFoto === "true";

            if (wajibFoto && fotoInput && fotoInput.files.length === 0) {
                const errFoto = document.getElementById("errorFoto");
                if (errFoto) errFoto.textContent = "Foto wajib dipilih.";
                fotoInput.classList.add("is-invalid");
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                alert("Form belum valid. Periksa kembali input Anda.");
            }
        });
    }

    // 5. Konfirmasi Hapus Data & File Media
    document.querySelectorAll(".media-delete-form").forEach(function (formDelete) {
        formDelete.addEventListener("submit", function (event) {
            const yakin = confirm(
                "Data dan file media terkait akan dihapus. Lanjutkan?"
            );

            if (!yakin) {
                event.preventDefault();
            }
        });
    });

    // 6. Search / Filter Real-Time Tabel Media
    const searchMedia = document.getElementById("searchMedia");
    const mediaTableBody = document.querySelector("#mediaTable tbody");
    const mediaRows = document.querySelectorAll("#mediaTable tbody tr:not([data-empty-row])");

    if (searchMedia && mediaTableBody && mediaRows.length > 0) {
        searchMedia.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            mediaRows.forEach(function (row) {
                const text = (row.dataset.search || row.textContent).toLowerCase();
                const isMatch = text.includes(keyword);
                row.style.display = isMatch ? "" : "none";
                if (isMatch) visibleCount++;
            });

            let noMatchRow = document.getElementById("noMatchMediaRow");
            if (visibleCount === 0) {
                if (!noMatchRow) {
                    noMatchRow = document.createElement("tr");
                    noMatchRow.id = "noMatchMediaRow";
                    noMatchRow.innerHTML =
                        '<td colspan="9" style="text-align: center; color: #64748b; padding: 20px;">Data mahasiswa yang dicari tidak ditemukan.</td>';
                    mediaTableBody.appendChild(noMatchRow);
                }
                noMatchRow.style.display = "";
            } else if (noMatchRow) {
                noMatchRow.style.display = "none";
            }
        });
    }

    // 7. Feedback Alert Berdasarkan Status URL Query
    const params = new URLSearchParams(window.location.search);
    const status = params.get("status");

    if (status === "tambah") alert("Data media berhasil ditambahkan.");
    else if (status === "update") alert("Data media berhasil diperbarui.");
    else if (status === "hapus") alert("Data media berhasil dihapus.");

    if (status && window.history && window.history.replaceState) {
        params.delete("status");
        const newQuery = params.toString();
        const newUrl = window.location.pathname + (newQuery ? "?" + newQuery : "");
        window.history.replaceState({}, document.title, newUrl);
    }
});
