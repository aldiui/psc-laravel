<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan kesalahan default yang digunakan oleh
    | kelas validator. Beberapa aturan ini memiliki versi yang berbeda seperti
    | aturan ukuran. Anda bebas untuk menyesuaikan setiap pesan di sini.
    |
     */

    'accepted' => ':Attribute harus diterima.',
    'accepted_if' => ':Attribute harus diterima ketika :other adalah :value.',
    'active_url' => ':Attribute harus URL yang valid.',
    'after' => ':Attribute harus tanggal setelah :date.',
    'after_or_equal' => ':Attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => ':Attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':Attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':Attribute hanya boleh berisi huruf dan angka.',
    'array' => ':Attribute harus berupa larik.',
    'ascii' => ':Attribute hanya boleh berisi karakter alfanumerik satu byte dan simbol.',
    'before' => ':Attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':Attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':Attribute harus memiliki antara :min dan :max item.',
        'file' => ':Attribute harus antara :min dan :max kilobita.',
        'numeric' => ':Attribute harus antara :min dan :max.',
        'string' => ':Attribute harus antara :min dan :max karakter.',
    ],
    'boolean' => ':Attribute harus true atau false.',
    'can' => ':Attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => ':Attribute harus tanggal yang valid.',
    'date_equals' => ':Attribute harus tanggal yang sama dengan :date.',
    'date_format' => ':Attribute harus cocok dengan format :format.',
    'decimal' => ':Attribute harus memiliki :decimal tempat desimal.',
    'declined' => ':Attribute harus ditolak.',
    'declined_if' => ':Attribute harus ditolak ketika :other adalah :value.',
    'different' => ':Attribute dan :other harus berbeda.',
    'digits' => ':Attribute harus :digits digit.',
    'digits_between' => ':Attribute harus antara :min dan :max digit.',
    'dimensions' => ':Attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => ':Attribute memiliki nilai duplikat.',
    'doesnt_end_with' => ':Attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => ':Attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => ':Attribute harus alamat email yang valid.',
    'ends_with' => ':Attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => 'Pilihan :attribute yang dipilih tidak valid.',
    'exists' => 'Pilihan :attribute yang dipilih tidak valid.',
    'extensions' => ':Attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => ':Attribute harus berupa berkas.',
    'filled' => ':Attribute harus memiliki nilai.',
    'gt' => [
        'array' => ':Attribute harus memiliki lebih dari :value item.',
        'file' => ':Attribute harus lebih besar dari :value kilobita.',
        'numeric' => ':Attribute harus lebih besar dari :value.',
        'string' => ':Attribute harus lebih besar dari :value karakter.',
    ],
    'gte' => [
        'array' => ':Attribute harus memiliki :value item atau lebih.',
        'file' => ':Attribute harus lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus lebih besar dari atau sama dengan :value.',
        'string' => ':Attribute harus lebih besar dari atau sama dengan :value karakter.',
    ],
    'hex_color' => ':Attribute harus warna heksadesimal yang valid.',
    'image' => ':Attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute yang dipilih tidak valid.',
    'in_array' => ':Attribute harus ada dalam :other.',
    'integer' => ':Attribute harus bilangan bulat.',
    'ip' => ':Attribute harus alamat IP yang valid.',
    'ipv4' => ':Attribute harus alamat IPv4 yang valid.',
    'ipv6' => ':Attribute harus alamat IPv6 yang valid.',
    'json' => ':Attribute harus string JSON yang valid.',
    'lowercase' => ':Attribute harus huruf kecil.',
    'lt' => [
        'array' => ':Attribute harus memiliki kurang dari :value item.',
        'file' => ':Attribute harus kurang dari :value kilobita.',
        'numeric' => ':Attribute harus kurang dari :value.',
        'string' => ':Attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':Attribute tidak boleh memiliki lebih dari :value item.',
        'file' => ':Attribute harus kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus kurang dari atau sama dengan :value.',
        'string' => ':Attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => ':Attribute harus alamat MAC yang valid.',
    'max' => [
        'array' => ':Attribute tidak boleh memiliki lebih dari :max item.',
        'file' => ':Attribute tidak boleh lebih besar dari :max kilobita.',
        'numeric' => ':Attribute tidak boleh lebih besar dari :max.',
        'string' => ':Attribute tidak boleh lebih besar dari :max karakter.',
    ],
    'max_digits' => ':Attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => ':Attribute harus berkas dengan tipe: :values.',
    'mimetypes' => ':Attribute harus berkas dengan tipe: :values.',
    'min' => [
        'array' => ':Attribute harus memiliki setidaknya :min item.',
        'file' => ':Attribute harus setidaknya :min kilobita.',
        'numeric' => ':Attribute harus setidaknya :min.',
        'string' => ':Attribute harus setidaknya :min karakter.',
    ],
    'min_digits' => ':Attribute harus memiliki setidaknya :min digit.',
    'missing' => ':Attribute harus hilang.',
    'missing_if' => ':Attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => ':Attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => ':Attribute harus hilang ketika :values hadir.',
    'missing_with_all' => ':Attribute harus hilang ketika :values hadir.',
    'multiple_of' => ':Attribute harus kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':Attribute harus angka.',
    'password' => [
        'letters' => ':Attribute harus mengandung setidaknya satu huruf.',
        'mixed' => ':Attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => ':Attribute harus mengandung setidaknya satu angka.',
        'symbols' => ':Attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan muncul dalam kebocoran data. Harap pilih :attribute yang berbeda.',
    ],
    'present' => ':Attribute harus ada.',
    'present_if' => ':Attribute harus ada ketika :other adalah :value.',
    'present_unless' => ':Attribute harus ada kecuali :other adalah :value.',
    'present_with' => ':Attribute harus ada ketika :values hadir.',
    'present_with_all' => ':Attribute harus ada ketika :values hadir.',
    'prohibited' => ':Attribute dilarang.',
    'prohibited_if' => ':Attribute dilarang ketika :other adalah :value.',
    'prohibited_unless' => ':Attribute dilarang kecuali :other adalah dalam :values.',
    'prohibits' => ':Attribute melarang :other dari ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':Attribute harus diisi.',
    'required_array_keys' => ':Attribute harus berisi entri untuk: :values.',
    'required_if' => ':Attribute diperlukan ketika :other adalah :value.',
    'required_if_accepted' => ':Attribute diperlukan ketika :other diterima.',
    'required_unless' => ':Attribute diperlukan kecuali :other ada dalam :values.',
    'required_with' => ':Attribute diperlukan ketika :values hadir.',
    'required_with_all' => ':Attribute diperlukan ketika :values hadir.',
    'required_without' => ':Attribute diperlukan ketika :values tidak ada.',
    'required_without_all' => ':Attribute diperlukan ketika tidak ada satu pun dari :values yang hadir.',
    'same' => ':Attribute dan :other harus cocok.',
    'size' => [
        'array' => ':Attribute harus berisi :size item.',
        'file' => ':Attribute harus :size kilobita.',
        'numeric' => ':Attribute harus :size.',
        'string' => ':Attribute harus :size karakter.',
    ],
    'starts_with' => ':Attribute harus diawali dengan salah satu dari: :values.',
    'string' => ':Attribute harus string.',
    'timezone' => ':Attribute harus zona waktu yang valid.',
    'unique' => ':Attribute sudah ada.',
    'uploaded' => ':Attribute gagal diunggah.',
    'uppercase' => ':Attribute harus huruf kapital.',
    'url' => ':Attribute harus URL yang valid.',
    'ulid' => ':Attribute harus ULID yang valid.',
    'uuid' => ':Attribute harus UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi khusus untuk atribut menggunakan
    | konvensi "attribute.rule" untuk memberi nama baris. Ini membuatnya cepat
    | untuk menentukan baris bahasa khusus tertentu untuk aturan atribut yang diberikan.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'pesan-kustom',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar tempat segnapembatas atribut kami
    | dengan sesuatu yang lebih mudah dibaca seperti "Alamat E-Mail" daripada "email".
    | Ini hanya membantu kami membuat pesan kami lebih ekspresif.
    |
     */

    'attributes' => [],

];
