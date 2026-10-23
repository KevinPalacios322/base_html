import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

interface Persona {
  id: number;
  dni: string;
  nombre: string;
  fechaNacimiento: string;
}

@Component({
  selector: 'app-persona',
  imports: [FormsModule],
  templateUrl: './persona.component.html',
  styleUrl: './persona.component.css',
})
export class PersonaComponent {
  personas: Persona[] = [];
  dni = '';
  nombre = '';
  fechaNacimiento = '';
  indiceEditar = -1;

  constructor(private router: Router) {
    if (localStorage.getItem('sesionBasica') !== 'si') {
      this.router.navigate(['/login']);
      return;
    }

    const datos = localStorage.getItem('personasBasico');
    if (datos !== null) {
      this.personas = JSON.parse(datos);
    }
  }

  cerrarSesion() {
    localStorage.removeItem('sesionBasica');
    this.router.navigate(['/login']);
  }

  editar(indice: number) {
    this.indiceEditar = indice;
    this.dni = this.personas[indice].dni;
    this.nombre = this.personas[indice].nombre;
    this.fechaNacimiento = this.personas[indice].fechaNacimiento;
  }

  limpiar() {
    this.dni = '';
    this.nombre = '';
    this.fechaNacimiento = '';
    this.indiceEditar = -1;
  }

  guardarEnLocalStorage() {
    localStorage.setItem('personasBasico', JSON.stringify(this.personas));
  }

  guardar() {
    if (
      this.dni.trim() === '' ||
      this.nombre.trim() === '' ||
      this.fechaNacimiento === ''
    ) {
      alert('Complete los tres campos');
      return;
    }

    if (this.indiceEditar === -1) {
      let nuevoId = 1;
      for (const persona of this.personas) {
        if (persona.id >= nuevoId) {
          nuevoId = persona.id + 1;
        }
      }

      this.personas.push({
        id: nuevoId,
        dni: this.dni.trim(),
        nombre: this.nombre.trim(),
        fechaNacimiento: this.fechaNacimiento,
      });
    } else {
      this.personas[this.indiceEditar].dni = this.dni.trim();
      this.personas[this.indiceEditar].nombre = this.nombre.trim();
      this.personas[this.indiceEditar].fechaNacimiento = this.fechaNacimiento;
    }
    this.guardarEnLocalStorage();
    this.limpiar();
  }
}
