import	{	Component	}	from	'@angular/core';
@Component({
		selector:	'app-saludo',
		imports:	[],
		templateUrl:	'./saludo.html',
		styleUrl:	'./saludo.css'
})
export	class	Saludo	{
		mensaje	=	'Este	texto	pertenece	al	componente	Saludo.';
}