<template>
    <form @submit.prevent="enviarFormulario" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Título</label>
        <input
          v-model="titulo"
          type="text"
          class="w-full border rounded px-3 py-2"
          placeholder="Escribe un título"
          required
        />
      </div>
  
      <div>
        <label class="block font-semibold mb-1">Contenido</label>
        <textarea
          v-model="contenido"
          class="w-full border rounded px-3 py-2"
          placeholder="Escribe el contenido de la nota"
          required
        ></textarea>
      </div>
  
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        {{ modoEdicion ? 'Actualizar nota' : 'Guardar nota' }}
      </button>
  
      <p v-if="mensaje" class="text-green-600 mt-2">{{ mensaje }}</p>
    </form>
  </template>
  
  <script>
  export default {
    name: "NotaForm",
    props: {
      notaParaEditar: {
        type: Object,
        default: null,
      },
    },
    data() {
      return {
        titulo: "",
        contenido: "",
        mensaje: "",
        modoEdicion: false,
        idNota: null,
      };
    },
    watch: {
      notaParaEditar(nuevaNota) {
        if (nuevaNota) {
          this.titulo = nuevaNota.titulo;
          this.contenido = nuevaNota.contenido;
          this.modoEdicion = true;
          this.idNota = nuevaNota.id;
          this.mensaje = "";
        }
      },
    },
    methods: {
      async enviarFormulario() {
        try {
          const url = this.modoEdicion
            ? `http://localhost:8000/api/notas/${this.idNota}`
            : "http://localhost:8000/api/notas";
  
          const metodo = this.modoEdicion ? "PUT" : "POST";
  
          const response = await fetch(url, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              titulo: this.titulo,
              contenido: this.contenido,
            }),
          });
  
          if (!response.ok) throw new Error("Error al guardar");
  
          this.mensaje = this.modoEdicion
            ? "✅ Nota actualizada con éxito"
            : "✅ Nota creada con éxito";
  
          this.titulo = "";
          this.contenido = "";
          this.idNota = null;
          this.modoEdicion = false;
  
          this.$emit("nota-creada"); // Refresca lista
        } catch (error) {
          console.error("Error al guardar nota:", error);
          this.mensaje = "❌ Ocurrió un error al guardar";
        }
      },
    },
  };
  </script>
  
  
  
  