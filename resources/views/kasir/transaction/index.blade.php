@extends('layouts.kasir')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8" x-data="transaction()">
    <h1 class="text-2xl font-bold mb-4">Transaksi Baru</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- Menu Items --}}
        <div class="lg:w-3/5m ">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($menus as $menu)
                <div class="border rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-300" @click="addToCart({{ $menu }})">
                    <h2 class="font-bold text-center">{{ $menu->name }}</h2>
                    <p class="text-sm text-gray-600">@rp($menu->price)</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Cart and Payment --}}
        <div class="lg:w-2/5">
            <div class="border rounded-lg p-4 bg-white">
                <h2 class="text-xl font-bold border-b pb-2 mb-4">Keranjang</h2>
                
                {{-- Cart Items --}}
                <div class="flex flex-col space-y-2 mb-4 max-h-60 overflow-y-auto">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold" x-text="item.name"></p>
                                <p class="text-sm text-gray-500" x-text="formatRupiah(item.price)"></p>
                            </div>
                            <div class="flex items-center">
                                <button @click="decrementQuantity(index)" class="px-2 py-1 bg-gray-200 rounded-md cursor-pointer">-</button>
                                <span class="px-4" x-text="item.quantity"></span>
                                <button @click="incrementQuantity(index)" class="px-2 py-1 bg-gray-200 rounded-md cursor-pointer">+</button>
                            </div>
                            <p class="font-semibold" x-text="formatRupiah(item.subtotal)"></p>
                        </div>
                    </template>
                    <template x-if="cart.length === 0">
                        <p class="text-gray-500 text-center">Keranjang kosong</p>
                    </template>
                </div>

                {{-- Totals --}}
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Subtotal</span>
                        <span x-text="formatRupiah(subtotal)"></span>
                    </div>
                     <div class="flex justify-between mb-2">
                        <span class="font-semibold">Pajak (0%)</span>
                        <span>@rp(0)</span>
                    </div>
                    <div class="flex justify-between font-bold text-xl mb-4">
                        <span>Total</span>
                        <span x-text="formatRupiah(total)"></span>
                    </div>

                    {{-- Payment --}}
                    <div class="mb-4">
                        <label for="paid_amount" class="block font-semibold mb-1">Jumlah Bayar</label>
                        <input type="number" id="paid_amount" x-model.number="paidAmount" class="w-full border rounded-md px-3 py-2">
                    </div>
                     <div class="flex justify-between text-lg mb-4">
                        <span>Kembalian</span>
                        <span x-text="change >= 0 ? formatRupiah(change) : '-'"></span>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        @click="submitTransaction" 
                        :disabled="cart.length === 0 || loading"
                        class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 disabled:bg-gray-400 cursor-pointer">
                        <span x-show="!loading">Proses Transaksi</span>
                        <span x-show="loading">Memproses...</span>
                    </button>
                    
                    {{-- Error Message --}}
                    <template x-if="errorMessage">
                        <p class="text-red-500 text-sm mt-2" x-text="errorMessage"></p>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function transaction() {
        return {
            cart: [],
            paidAmount: 0,
            loading: false,
            errorMessage: '',

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            },

            get subtotal() {
                return this.cart.reduce((total, item) => total + item.subtotal, 0);
            },
            
            get total() {
                // Assuming no tax for now
                return this.subtotal;
            },

            get change() {
                return this.paidAmount - this.total;
            },

            addToCart(menu) {
                const existingItem = this.cart.find(item => item.id === menu.id);
                if (existingItem) {
                    existingItem.quantity++;
                    existingItem.subtotal = existingItem.price * existingItem.quantity;
                } else {
                    this.cart.push({
                        id: menu.id,
                        name: menu.name,
                        price: menu.price,
                        quantity: 1,
                        subtotal: menu.price,
                    });
                }
            },

            incrementQuantity(index) {
                this.cart[index].quantity++;
                this.cart[index].subtotal = this.cart[index].price * this.cart[index].quantity;
            },

            decrementQuantity(index) {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                    this.cart[index].subtotal = this.cart[index].price * this.cart[index].quantity;
                } else {
                    this.cart.splice(index, 1);
                }
            },

            async submitTransaction() {
                this.loading = true;
                this.errorMessage = '';

                const items = this.cart.map(item => ({ menu_id: item.id, quantity: item.quantity }));

                try {
                    const response = await fetch('{{ route("kasir.transaction.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: items,
                            paid_amount: this.paidAmount
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Terjadi kesalahan saat memproses transaksi.');
                    }
                    
                    // On success, reset the state
                    alert('Transaksi berhasil!');
                    this.cart = [];
                    this.paidAmount = 0;

                } catch (error) {
                    this.errorMessage = error.message;
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
