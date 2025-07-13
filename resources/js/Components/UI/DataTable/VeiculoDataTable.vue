<template>
    <div class="bg-white rounded-lg shadow p-4">
        <table
            class="table-auto w-full border-separate border-spacing-0 rounded-lg border border-blue-600"
        >
            <thead>
                <tr>
                    <th class="w-[20%] border border-gray-300 px-4 py-2">
                        Modelo
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Ano
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Data Aquisição
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        KM Aquisição
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Renavam
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Placa
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="veiculo in veiculos.data"
                    :key="veiculo.id"
                    class="hover:bg-gray-100"
                >
                    <td class="border text-center border-gray-300 px-4 py-2">
                        <a
                            @click.prevent="
                                () => {
                                    console.log('ID do veículo:', veiculo.id);
                                    $inertia.visit(
                                        route('veiculos.show', veiculo.id)
                                    );
                                }
                            "
                            class="hover:underline cursor-pointer"
                        >
                            {{ veiculo.modelo }}
                        </a>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ veiculo.ano }}
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ veiculo.data_aquisicao }}
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ veiculo.km_aquisicao }}
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ veiculo.renavam }}
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        {{ veiculo.placa }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex justify-center gap-4">
            <button
                :disabled="veiculos.currentPage <= 1"
                @click="mudarPagina(veiculos.currentPage - 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowLeft />
            </button>

            <button
                :disabled="veiculos.currentPage >= veiculos.lastPage"
                @click="mudarPagina(veiculos.currentPage + 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowRight />
            </button>
        </div>
        <div class="mt-4 text-center text-gray-500">
            Páginas {{ veiculos.currentPage }} de {{ veiculos.lastPage }}
        </div>
    </div>
</template>

<script setup>
import { ArrowLeft, ArrowRight } from "lucide-vue-next";
import DeleteButton from "../Buttons/DeleteButton.vue";
import EditButton from "../Buttons/EditButton.vue";
import { router } from "@inertiajs/vue3";
import CancelButton from "../Buttons/CancelButton.vue";
import SalvarButton from "../Buttons/SaveButton.vue";
import ConfirmModal from "../Modal/ConfirmModal.vue";
import InputField from "../Inputs/InputField.vue";

defineProps({
    veiculos: Object,
});

function mudarPagina(novaPagina) {
    router.get(
        route("veiculos.index"),
        { page: novaPagina },
        {
            preserveState: true,
            replace: true,
        }
    );
}
</script>
