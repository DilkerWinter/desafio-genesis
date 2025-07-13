<template>
    <div class="bg-white rounded-lg shadow p-4">
        <table
            class="table-auto w-full border-separate border-spacing-0 rounded-lg border border-blue-600"
        >
            <thead>
                <tr>
                    <th class="w-[20%] border border-gray-300 px-4 py-2">
                        Motorista
                    </th>
                    <th class="w-[20%] border border-gray-300 px-4 py-2">
                        Veículo
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        KM Inicial
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        KM Final
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Distância
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Data Inicial
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Data Final
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Duração
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Acessar
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="viagem in viagens.data"
                    :key="viagem.id"
                    class="hover:bg-gray-100"
                >
                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="viagem.motorista">
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
                        </template>
                        <template v-else> Não informado </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="viagem.veiculo">
                            <a
                                @click.prevent="
                                    $inertia.visit(
                                        route(
                                            'veiculos.show',
                                            viagem.veiculo.id
                                        )
                                    )
                                "
                                class="hover:underline cursor-pointer"
                            >
                                {{ viagem.veiculo.modelo }}
                            </a>
                        </template>
                        <template v-else> Não informado </template>
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.km_inicial }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.km_final }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.distancia_total }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.data_inicial }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.data_final }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ viagem.duracao_total }}
                    </td>
                    <td class="border text-center border-gray-300 px-4 py-2">
                        <RedirectButton
                            @click.prevent="
                                $inertia.visit(route('viagens.show', viagem.id))
                            "
                        />
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex justify-center gap-4">
            <button
                :disabled="viagens.currentPage <= 1"
                @click="mudarPagina(viagens.currentPage - 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowLeft />
            </button>
            <button
                :disabled="viagens.currentPage >= viagens.lastPage"
                @click="mudarPagina(viagens.currentPage + 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowRight />
            </button>
        </div>

        <div class="mt-4 text-center text-gray-500">
            Páginas {{ viagens.currentPage }} de {{ viagens.lastPage }}
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ArrowLeft, ArrowRight } from "lucide-vue-next";
import RedirectButton from "../Buttons/RedirectButton.vue";

defineProps({
    viagens: Object,
});

function mudarPagina(novaPagina) {
    router.get(
        route("viagens.index"),
        { page: novaPagina },
        {
            preserveState: true,
            replace: true,
        }
    );
}
</script>
