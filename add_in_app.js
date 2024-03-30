function dataTableController(id) {
    return {
        id: id,
        deleteItem: function deleteItem() {
            var _this = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('deleteItem', _this.id);
                }
            });
        },
        addInvoice: function addInvoice() {
            var _this = this;
            console.log(this);

            Swal.fire({
                title: 'Apakah kamu yakin untuk mencetak invoice?',
                text: "Aksi tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, cetak!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('addInvoice', _this.id);
                }
            });
        },
        addPayment: function addPayment() {
            var _this = this;

            Swal.fire({
                title: 'Apakah kamu yakin untuk menambah pelunasan?',
                text: "Aksi tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tambah!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('addPayment', _this.id);
                }
            });
        },
        acceptPayment: function acceptPayment() {
            var _this = this;
            console.log(this);

            Swal.fire({
                title: 'Apakah kamu yakin untuk menerima pembayaran?',
                text: "Aksi tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, setujui!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('acceptPayment', _this.id);
                }
            });
        },
        declinePayment: function declinePayment() {
            var _this = this;
            console.log(this);

            Swal.fire({
                title: 'Apakah kamu yakin untuk menolak pembayaran?',
                text: "Aksi tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tolak!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('declinePayment', _this.id);
                }
            });
        },
        customerSuspend: function customerSuspend() {
            var _this = this;
            console.log(this);

            Swal.fire({
                title: 'Apakah kamu yakin untuk suspend pelanggan?',
                text: "Aksi tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, suspend!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    Livewire.emit('customerSuspend', _this.id);
                }
            });
        }
    };
}

function dataTableMainController() {
    return {
        setCallback: function setCallback() {
            Livewire.on('deleteResult', function (result) {
                if (result.status) {
                    Swal.fire('Deleted!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
            Livewire.on('addInvoiceResult', function (result) {
                if (result.status) {
                    Swal.fire('Invoice berhasil ditambah!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
            Livewire.on('addPaymentResult', function (result) {
                if (result.status) {
                    Swal.fire('Pembayaran berhasil ditambah!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
            Livewire.on('acceptPaymentResult', function (result) {
                if (result.status) {
                    Swal.fire('Pembayaran berhasil diterima!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
            Livewire.on('declinePaymentResult', function (result) {
                if (result.status) {
                    Swal.fire('Pembayaran berhasil ditolak!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
            Livewire.on('customerSuspendResult', function (result) {
                if (result.status) {
                    Swal.fire('Pelanggan berhasil suspend!', result.message, 'success');
                } else {
                    Swal.fire('Error!', result.message, 'error');
                }
            });
        }
    };
}
