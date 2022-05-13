/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import java.io.IOException;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;
/**
 *
 * @author Salma
 */
public class FirstWindow extends Application {
   @Override
    public void start(Stage primaryStage){
        
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionMenu.fxml"));
        Parent root;
        try {
        root = loader.load();
        Scene scene = new Scene(root);
        primaryStage.setTitle(" Devpros");
        primaryStage.setScene(scene);
        primaryStage.show();
        } catch (IOException ex) {
           System.out.println(ex.getMessage());
        }
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
    
}