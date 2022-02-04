function cekStatusPasien(uri = null, medrec = null, no_kartu = null, nik = null) {
    if (uri) {
        let regno = $('#Regno').val()
    
        if (!regno) {
            $('#form_type').val('insert')
            axios.get(uri, {params: {
                medrec: medrec,
                no_kartu: no_kartu,
                nik: nik
            }}).then(response => {
                if (response.data.status == 'success') {
                    if (response.data.closed == 'no') {
                        alert ('Registrasi sebelumnya belum closing. Kode Kunjungan: ' + response.data.history_kunjungan.I_Kunjungan)
                        return false
                    } else {
                        return true
                    }
                }
            }).catch(error => {
                if ('message' in error) {
                    alert (error.message)
                }
                return false
            })
        } else {
            $('#form_type').val('update')
            return true
        }
    }
}