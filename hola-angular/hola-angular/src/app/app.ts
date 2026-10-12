import	{	Component,	signal	}	from	'@angular/core';
import	{	Saludo	}	from	'./saludo/saludo';
@Component({
		selector:	'app-root',
		imports:	[Saludo],
		templateUrl:	'./app.html',
		styleUrl:	'./app.css'
})
export	class	App	{
		readonly	nombre	=	signal('Angular');
		readonly	contador	=	signal(0);
		incrementar():	void	{
				this.contador.update(valor	=>	valor	+	1);
		}
		reiniciar():	void	{
				this.contador.set(0);
		}
}