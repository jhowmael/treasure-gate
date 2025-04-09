@extends('layouts.web')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md" 
     x-data="walletManager()">
     
    <!-- Cards lado a lado -->
    <div class="grid grid-cols-2 gap-3">
        
        <!-- MEXC -->
        <div class="arbitrage-card bg-gray-900 p-4 rounded-xl shadow-xl">
            <h2 class="text-xl text-white font-semibold mb-2 flex items-center gap-2">
                <img class="w-7 h-7" src="{{ asset('mexc-logo.svg') }}" alt="MEXC Logo">
                <strong>MEXC</strong>
            </h2>
            <p class="text-white text-lg mb-2">Saldo: $<span x-text="(mexcBalance).toFixed(2)"></span></p>
            
            <button @click="showMexcForm()"
                class="button-link mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg w-full">
                Alterar Saldo
            </button>
        </div>
        
        <!-- Gate.io -->
        <div class="arbitrage-card bg-gray-900 p-4 rounded-xl shadow-xl">
            <h2 class="text-xl text-white font-semibold mb-2 flex items-center gap-2">
                <img class="w-7 h-7" src="{{ asset('gate.io.svg') }}" alt="Gate Logo">
                <strong>Gate.io</strong>
            </h2>
            <p class="text-white text-lg mb-2">Saldo: $<span x-text="(gateBalance).toFixed(2)"></span></p>
            
            <button @click="showGateForm()"
                class="button-link mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg w-full">
                Alterar Saldo
            </button>
        </div>
    </div>
    
    <!-- Modal flutuante para edição de saldo -->
    <div x-show="activeForm"
         x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm rounded-xl p-6 shadow-lg"
             @click.outside="activeForm = null">
             
            <h3 class="text-lg font-bold mb-4 text-gray-800" 
                x-text="activeForm === 'mexc' ? 'Editar Saldo - MEXC' : 'Editar Saldo - Gate.io'"></h3>
            
            <form @submit.prevent="activeForm === 'mexc' ? updateMexcBalance() : updateGateBalance()">
                
                <!-- Campo para MEXC -->
                <template x-if="activeForm === 'mexc'">
                    <input type="number" step="0.01"
                        x-model.number="tempMexcAmount"
                        class="w-full mb-4 p-2 border rounded text-sm text-black">
                </template>

                <!-- Campo para Gate -->
                <template x-if="activeForm === 'gate'">
                    <input type="number" step="0.01"
                        x-model.number="tempGateAmount"
                        class="w-full mb-4 p-2 border rounded text-sm text-black">
                </template>

                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                        Salvar
                    </button>
                    <button type="button" @click="activeForm = null"
                        class="bg-gray-500 text-white px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mensagem de notificação -->
    <div x-show="notification.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50"
         :class="notification.type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
        <p x-text="notification.message"></p>
    </div>
</div>

<script>
    function walletManager() {
        return {
            mexcBalance: {{ $walletData[auth()->id()]['mexc'] ?? 0 }},
            gateBalance: {{ $walletData[auth()->id()]['gate'] ?? 0 }},
            tempMexcAmount: {{ $walletData[auth()->id()]['mexc'] ?? 0 }},
            tempGateAmount: {{ $walletData[auth()->id()]['gate'] ?? 0 }},
            activeForm: null,
            notification: {
                show: false,
                message: '',
                type: 'success',
                timer: null
            },
            
            showMexcForm() {
                this.tempMexcAmount = this.mexcBalance;
                this.activeForm = 'mexc';
            },
            
            showGateForm() {
                this.tempGateAmount = this.gateBalance;
                this.activeForm = 'gate';
            },
            
            updateMexcBalance() {
                fetch('{{ route('wallet.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        exchange: 'mexc',
                        amount: this.tempMexcAmount
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    this.mexcBalance = parseFloat(this.tempMexcAmount);
                    this.activeForm = null;
                    this.showNotification('Saldo MEXC atualizado com sucesso!', 'success');
                })
                .catch(error => {
                    console.error('Erro ao atualizar saldo:', error);
                    this.showNotification('Erro ao atualizar saldo. Tente novamente.', 'error');
                });
            },
            
            updateGateBalance() {
                fetch('{{ route('wallet.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        exchange: 'gate',
                        amount: this.tempGateAmount
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    this.gateBalance = parseFloat(this.tempGateAmount);
                    this.activeForm = null;
                    this.showNotification('Saldo Gate.io atualizado com sucesso!', 'success');
                })
                .catch(error => {
                    console.error('Erro ao atualizar saldo:', error);
                    this.showNotification('Erro ao atualizar saldo. Tente novamente.', 'error');
                });
            },
            
            showNotification(message, type = 'success') {
                if (this.notification.timer) clearTimeout(this.notification.timer);
                this.notification.show = true;
                this.notification.message = message;
                this.notification.type = type;
                this.notification.timer = setTimeout(() => {
                    this.notification.show = false;
                }, 3000);
            }
        }
    }
</script>
@endsection
