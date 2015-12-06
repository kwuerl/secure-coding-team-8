/**
 * FilePicker class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 *
 * Part of code taken from http://www.codejava.net/java-se/swing/file-picker-component-in-swing
 */

package securebank.scs.ui.components;
import java.awt.Color;
import java.awt.FlowLayout;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
 
import javax.swing.JButton;
import javax.swing.JFileChooser;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;
 
@SuppressWarnings("serial")
public class JFilePicker extends JPanel {
    private JLabel label;
    private JTextField textField;
    private JButton button;
     
    private JFileChooser fileChooser;
     
    private int mode;
    public static final int MODE_OPEN = 1;
    public static final int MODE_SAVE = 2;
     
    public JFilePicker(String textFieldLabel, String buttonLabel) {
        fileChooser = new JFileChooser();
         
        setLayout(new FlowLayout(FlowLayout.LEFT, 5, 5));
 
        // creates the GUI
        label = new JLabel(textFieldLabel);
        label.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
         
        textField = new JTextField(15);
        textField.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
        
        button = new JButton(buttonLabel);
        button.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
        button.setForeground(Color.WHITE);
        button.setBackground(Color.GRAY);
         
        button.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                buttonActionPerformed(evt);            
            }
        });
         
        add(label);
        add(textField);
        add(button);

    }
     
    private void buttonActionPerformed(ActionEvent evt) {
        if (mode == MODE_OPEN) {
            if (fileChooser.showOpenDialog(this) == JFileChooser.APPROVE_OPTION) {
                textField.setText(fileChooser.getSelectedFile().getAbsolutePath());
            }
        } else if (mode == MODE_SAVE) {
            if (fileChooser.showSaveDialog(this) == JFileChooser.APPROVE_OPTION) {
                textField.setText(fileChooser.getSelectedFile().getAbsolutePath());
            }
        }
    }
 
    public void addFileTypeFilter(String extension, String description) {
        FileTypeFilter filter = new FileTypeFilter(extension, description);
        fileChooser.setFileFilter(filter);
    }
     
    public void setMode(int mode) {
        this.mode = mode;
    }
     
    public String getSelectedFilePath() {
        return textField.getText();
    }
     
    public JFileChooser getFileChooser() {
        return this.fileChooser;
    }
}