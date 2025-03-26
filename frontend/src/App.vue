<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">🗒️ Gestor de Notas</h1>

    <div class="flex flex-col items-center">
      <div class="bg-white p-6 rounded shadow-md w-full max-w-md mb-10">
        <h2 class="text-xl font-bold text-blue-700 mb-4">📝 Crear nueva nota</h2>

        <NotaForm
          :notaParaEditar="notaSeleccionada"
          @nota-creada="refrescarNotas"
        />
      </div>

      <div class="w-full max-w-2xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
          📋 Lista de notas
        </h2>

        <NotaList
          :notas="notas"
          @nota-eliminada="refrescarNotas"
          @editar-nota="notaSeleccionada = $event"
        />
      </div>
    </div>
  </div>
</template>

<script>
import NotaForm from "./components/NotaForm.vue";
import NotaList from "./components/NotaList.vue";

export default {
  name: "App",
  components: { NotaForm, NotaList },
  data() {
    return {
      notas: [],
      notaSeleccionada: null,
    };
  },
  methods: {
    async refrescarNotas() {
      try {
        const response = await fetch("http://localhost:8000/api/notas");
        this.notas = await response.json();
      } catch (error) {
        console.error("Error al cargar notas:", error);
      }
    },
  },
  mounted() {
    this.refrescarNotas();
  },
};
</script>






