import { Component, HostListener } from '@angular/core';

@Component({
  selector: 'app-calculadora',
  styleUrl: './calculadora.css',
  templateUrl: './calculadora.html',
})
export class Calculadora {
  pantalla = '0';
  private primerNumero: number | null = null;
  private operacion: string | null = null;
  private esperaSegundoNumero = false;

  escribirNumero(numero: string): void {
    if (this.pantalla === 'Error' || this.esperaSegundoNumero) {
      this.pantalla = numero;
      this.esperaSegundoNumero = false;
      return;
    }
    this.pantalla = this.pantalla === '0' ? numero : this.pantalla + numero;
  }

  agregarDecimal(): void {
    if (this.pantalla === 'Error' || this.esperaSegundoNumero) {
      this.pantalla = '0.';
      this.esperaSegundoNumero = false;
    } else if (!this.pantalla.includes('.')) this.pantalla += '.';
  }

  elegirOperacion(nuevaOperacion: string): void {
    if (this.pantalla === 'Error') return;
    if (this.primerNumero !== null && !this.esperaSegundoNumero) this.calcular();
    else this.primerNumero = Number(this.pantalla);
    this.operacion = nuevaOperacion;
    this.esperaSegundoNumero = true;
  }

  calcular(): void {
    if (this.primerNumero === null || this.operacion === null || this.esperaSegundoNumero) return;
    const segundoNumero = Number(this.pantalla);
    let resultado: number;
    switch (this.operacion) {
      case '+': resultado = this.primerNumero + segundoNumero; break;
      case '−': resultado = this.primerNumero - segundoNumero; break;
      case '×': resultado = this.primerNumero * segundoNumero; break;
      case '÷':
        if (segundoNumero === 0) { this.pantalla = 'Error'; this.limpiarEstado(); return; }
        resultado = this.primerNumero / segundoNumero; break;
      default: return;
    }
    this.pantalla = String(Number(resultado.toPrecision(12)));
    this.primerNumero = null;
    this.operacion = null;
    this.esperaSegundoNumero = true;
  }

  borrar(): void {
    if (this.esperaSegundoNumero || this.pantalla === 'Error') { this.pantalla = '0'; this.esperaSegundoNumero = false; return; }
    this.pantalla = this.pantalla.length > 1 ? this.pantalla.slice(0, -1) : '0';
  }

  limpiar(): void { this.pantalla = '0'; this.limpiarEstado(); }

  @HostListener('window:keydown', ['$event'])
  usarTeclado(evento: KeyboardEvent): void {
    if (/^\d$/.test(evento.key)) this.escribirNumero(evento.key);
    else if (evento.key === '.') this.agregarDecimal();
    else if (evento.key === '+' || evento.key === '-') this.elegirOperacion(evento.key === '-' ? '−' : '+');
    else if (evento.key === '*') this.elegirOperacion('×');
    else if (evento.key === '/') { evento.preventDefault(); this.elegirOperacion('÷'); }
    else if (evento.key === 'Enter' || evento.key === '=') this.calcular();
    else if (evento.key === 'Escape') this.limpiar();
    else if (evento.key === 'Backspace') this.borrar();
  }

  private limpiarEstado(): void { this.primerNumero = null; this.operacion = null; this.esperaSegundoNumero = false; }
}
