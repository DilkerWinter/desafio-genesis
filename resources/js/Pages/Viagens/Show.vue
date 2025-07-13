<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Detalhes da Viagem
                </h1>

                <button
                    @click="$inertia.visit(route('viagens.index'))"
                    class="bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-gray-700 transition"
                >
                    Lista de Viagens
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">
                    Informações da Viagem
                </h2>

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800"
                >
                    <div>
                        <p class="font-semibold">Motorista</p>
                        <a
                            @click.prevent="
                                $inertia.visit(
                                    route(
                                        'motoristas.show',
                                        viagem.motorista.id
                                    )
                                )
                            "
                            class="hover:underline cursor-pointer"
                        >
                            {{ viagem.motorista.nome }}
                        </a>
                    </div>
                    <div>
                        <p class="font-semibold">Veículo</p>
                        <a
                            @click.prevent="
                                $inertia.visit(
                                    route('veiculos.show', viagem.veiculo.id)
                                )
                            "
                            class="hover:underline cursor-pointer"
                        >
                            {{ viagem.veiculo.modelo }} ({{
                                viagem.veiculo.placa
                            }})
                        </a>
                    </div>
                    <div>
                        <p class="font-semibold">Kilometragem do Veiculo Inicial</p>
                        <p>{{ viagem.km_inicial }} km</p>
                    </div>
                    <div>
                        <p class="font-semibold">Kilometragem do Veiculo Final</p>
                        <p>{{ viagem.km_final }} km</p>
                    </div>
                    <div>
                        <p class="font-semibold">Distância Total</p>
                        <p>{{ viagem.distancia_total }} Km</p>
                    </div>
                    <div>
                        <p class="font-semibold">Data Inicial</p>
                        <p>{{ formatarData(viagem.data_hora_inicial) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Hora Inicial</p>
                        <p>{{ formatarHora(viagem.data_hora_inicial) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Data Final</p>
                        <p>{{ formatarData(viagem.data_hora_final) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Hora Final</p>
                        <p>{{ formatarHora(viagem.data_hora_final) }}</p>
                    </div>

                    <div>
                        <p class="font-semibold">Duração Total</p>
                        <p>{{ viagem.duracao_total }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    viagem: {
        type: Object,
        required: true,
    },
});

function formatarData(dataStr) {
    if (!dataStr) return "-";
    const data = new Date(dataStr);
    const dia = data.getDate().toString().padStart(2, "0");
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}

function formatarHora(dataStr) {
    if (!dataStr) return "-";
    const data = new Date(dataStr);
    const hora = data.getHours().toString().padStart(2, "0");
    const minuto = data.getMinutes().toString().padStart(2, "0");
    return `${hora}:${minuto}`;
}
</script>
