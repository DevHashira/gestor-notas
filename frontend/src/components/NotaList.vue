<template>
    <div>
      <div v-if="notas.length === 0" class="text-gray-500">No hay notas aún.</div>
  
      <div
        v-for="nota in notas"
        :key="nota.id"
        class="bg-white p-4 rounded shadow mb-4 flex justify-between items-start"
      >
        <div>
          <h3 class="text-lg font-semibold text-blue-700">{{ nota.titulo }}</h3>
          <p class="text-gray-700">{{ nota.contenido }}</p>
          <p class="text-sm text-gray-400 mt-1">
            Creado: {{ formatearFecha(nota.created_at) }}
          </p>
        </div>
  
        <div class="flex space-x-2">
          <button
            @click="$emit('editar-nota', nota)"
            class="text-yellow-500 hover:text-yellow-600"
            title="Editar nota"
          >
            ✏️
          </button>
          <button
            @click="eliminarNota(nota.id)"
            class="text-gray-600 hover:text-red-600"
            title="Eliminar nota"
          >
            🗑️
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "NotaList",
    props: {
      notas: {
        type: Array,
        required: true,
      },
    },
    methods: {
      async eliminarNota(id) {
        const confirmar = confirm("¿Estás seguro de eliminar esta nota?");
        if (!confirmar) return;
  
        try {
          const response = await fetch(`http://localhost:8000/api/notas/${id}`, {
            method: "DELETE",
          });
  
          if (!response.ok) throw new Error("Error al eliminar");
  
          this.$emit("nota-eliminada"); // Notifica al padre que recargue
        } catch (error) {
          console.error("Error al eliminar nota:", error);
          alert("❌ Ocurrió un error al eliminar");
        }
      },
      formatearFecha(fecha) {
        const opciones = {
          year: "numeric",
          month: "numeric",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit",
        };
        return new Date(fecha).toLocaleString("es-ES", opciones);
      },
    },
  };
  </script>
  
  
  
  
  
  
  