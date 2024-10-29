<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>


<template>

    <Head title="Meus Quadros" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="h-screen flex flex-col">
                    <!-- Header -->

                    <!-- Main Content -->
                    <main class="flex-1 overflow-auto p-4 bg-gray-100">
                        <!-- Lists Container -->
                        <div class="flex space-x-4">
                            <!-- List -->
                            <div class="w-64 bg-gray-200 rounded p-2 flex-shrink-0">
                                <h2 class="font-bold mb-2">A Fazer</h2>
                                <!-- Cards -->
                                <div class="space-y-2">
                                    <div class="bg-white p-2 rounded shadow">Tarefa 1</div>
                                    <div class="bg-white p-2 rounded shadow">Tarefa 2</div>
                                    <!-- Adicione mais cartões -->
                                </div>
                                <!-- Add Card Button -->
                                <button class="mt-2 text-sm text-blue-600">+ Adicionar cartão</button>
                            </div>
                            <div class="w-64 bg-gray-200 rounded p-2 flex-shrink-0">
                                <h2 class="font-bold mb-2">Em Progresso</h2>
                                <!-- Cartões -->
                                <div class="space-y-2">
                                    <div class="bg-white p-2 rounded shadow">Tarefa 3</div>
                                    <!-- Adicione mais cartões -->
                                </div>
                                <!-- Botão Adicionar Cartão -->
                                <button class="mt-2 text-sm text-blue-600">+ Adicionar cartão</button>
                            </div>
                            <!-- Repita para mais listas -->
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: 'Board',
    // Adicione sua lógica aqui
};
</script>

<style>
/* Se precisar de estilos adicionais */
</style>
