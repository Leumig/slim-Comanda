<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $rol = $parametros['rol'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->nombre = $nombre;
        $usr->apellido = $apellido;
        $usr->rol = $rol;
        $usr->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por id
        $id = $args['id'];
        $usuario = Usuario::obtenerUsuario($id);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaDeUsuarios" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $args['id'];
        var_dump($id);
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $rol = $parametros['rol'];
        Usuario::modificarUsuario($id, $nombre, $apellido, $rol);

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $args['id'];
        Usuario::borrarUsuario($id);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}