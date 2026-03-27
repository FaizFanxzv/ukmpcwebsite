function handleStatusChange() {
    const statusSelect = document.getElementById('status');
    const status = statusSelect.value.toLowerCase();
    const aktifDiv = document.querySelector('.mb-3:has(input[name="aktif"] )');
    const aktifYa = document.getElementById('aktif_ya');
    
    if (status === 'hadir') {
        aktifDiv.style.display = 'block';
        // Allow selection for hadir
    } else {
        // For izin, sakit, alpha: force tidak, hide
        aktifDiv.style.display = 'none';
        document.querySelector('input[name="aktif"][value="tidak"]').checked = true;
        aktifYa.checked = false;
        
        // Immediate alert if ya was selected
        if (aktifYa.checked) {
            alert('Gagal menambahkan data karena tidak masuk logika, ulangi lagi. Wajib pilih "Tidak" untuk status ini.');
        }
    }
}

function updateJadwal() {
    const anggotaSelect = document.getElementById('anggota_id');
    const jadwalSelect = document.getElementById('jadwal_id');
    const anggotaId = anggotaSelect.value;
    
    if (anggotaId === 'pilih') {
        jadwalSelect.innerHTML = '<option value="Pilih" selected>Pilih Jadwal</option>';
        return;
    }
    
    fetch('get_jadwal_by_anggota.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'anggota_id=' + encodeURIComponent(anggotaId)
    })
    .then(response => response.json())
    .then(jadwals => {
        jadwalSelect.innerHTML = '<option value="Pilih" selected>Pilih Jadwal</option>';
        jadwals.forEach(jadwal => {
            const option = document.createElement('option');
            option.value = jadwal.id;
            option.text = jadwal.text;
            jadwalSelect.appendChild(option);
        });
        // Auto-select first option if available
        if (jadwals.length > 0) {
            jadwalSelect.selectedIndex = 1;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        jadwalSelect.innerHTML = '<option value="Pilih" selected>Pilih Jadwal</option>';
    });
}

// Form submit validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = document.getElementById('status').value.toLowerCase();
            const aktif = document.querySelector('input[name="aktif"]:checked').value;
            
            // Invalid if status izin/sakit/alpha AND aktif=ya
            if ((status === 'izin' || status === 'sakit' || status === 'alpha') && aktif === 'ya') {
                e.preventDefault();
                alert('Gagal menambahkan data karena tidak masuk logika, ulangi lagi. Wajib pilih "Tidak" untuk status Izin, Sakit, atau Alpha.');
                return false;
            }
            
            if (!confirm('Apakah Anda yakin ingin menyimpan data ini?')) {
                e.preventDefault();
            }
        });
    });

    // Logout validation - confirm before logout
    const logoutLinks = document.querySelectorAll('a[href="logout.php"]');
    logoutLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    });
});
