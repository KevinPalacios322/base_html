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

  limpiar() {
    this.dni = '';
    this.nombre = '';
    this.fechaNacimiento = '';
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
    this.guardarEnLocalStorage();
    this.limpiar();
  }
}
