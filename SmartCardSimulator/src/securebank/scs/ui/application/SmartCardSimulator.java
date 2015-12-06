/**
 * SmartCardSimulator class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 */

package securebank.scs.ui.application;

import javax.swing.UIManager;
import javax.swing.JFrame;
import javax.swing.JTabbedPane;
import javax.swing.JPanel;
import javax.swing.JLabel;
import javax.swing.JTextField;
import javax.swing.SwingConstants;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.awt.event.ActionEvent;
import javax.swing.border.LineBorder;
import securebank.scs.helpers.TanGenerator;
import securebank.scs.ui.components.JFilePicker;

import java.awt.Color;
import java.awt.Font;
import javax.swing.JTextPane;

public class SmartCardSimulator {

	public JFrame frmSecureBank;
	private JTextField fieldRecipientAccountId;
	private JTextField fieldAmount;
	private JTextField fieldScsPin;
	private JTextPane textPaneSingle;
	private JTextPane textPaneBatch;
	private TanGenerator tanGenerator;
	private JTextField fieldScsPinBatch;
	
	/**
	 * Initialize the smart card simulator.
	 */
	public SmartCardSimulator() {
		initialize();
	}

	/**
	 * Initialize the contents of the frame.
	 */
	private void initialize() {
		frmSecureBank = new JFrame();
		frmSecureBank.setTitle("SecureBank - Smart Card Simulator");
		frmSecureBank.getContentPane().setBackground(new Color(102, 102, 102));
		frmSecureBank.setBackground(Color.WHITE);
		frmSecureBank.setBounds(100, 100, 450, 300);
		frmSecureBank.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frmSecureBank.getContentPane().setLayout(null);
		

		UIManager.put("TabbedPane.contentAreaColor", Color.DARK_GRAY);
		UIManager.put("TabbedPane.light", Color.GRAY);
		UIManager.put("TabbedPane.highlight", Color.GRAY);
		UIManager.put("TabbedPane.shadow", Color.GRAY);
		UIManager.put("TabbedPane.darkShadow", Color.DARK_GRAY);
		UIManager.put("TabbedPane.selected", Color.LIGHT_GRAY);
		UIManager.put("TabbedPane.borderHightlightColor", Color.GRAY);
		
		
		JTabbedPane tabbedPane = new JTabbedPane(SwingConstants.TOP);
		tabbedPane.setFont(new Font("Century Schoolbook L", Font.BOLD, 14));
		tabbedPane.setBackground(Color.WHITE);
		tabbedPane.setBounds(12, 12, 426, 248);
		
		frmSecureBank.getContentPane().add(tabbedPane);

		JPanel panelSingle = new JPanel();
		panelSingle.setBackground(Color.WHITE);
		tabbedPane.addTab("Single Transaction", null, panelSingle, null);
		panelSingle.setLayout(null);
		
		JLabel lblRecipientAccountId = new JLabel("Recipient Account ID*");
		lblRecipientAccountId.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblRecipientAccountId.setBounds(23, 26, 140, 25);
		panelSingle.add(lblRecipientAccountId);
		
		JLabel lblAmount = new JLabel("Amount*");
		lblAmount.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblAmount.setBounds(23, 66, 140, 25);
		panelSingle.add(lblAmount);
		
		JLabel lblScsPin = new JLabel("SCS Pin*");
		lblScsPin.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		lblScsPin.setBounds(23, 106, 140, 25);
		panelSingle.add(lblScsPin);
		
		fieldRecipientAccountId = new JTextField();
		fieldRecipientAccountId.setBounds(224, 26, 140, 25);
		panelSingle.add(fieldRecipientAccountId);
		fieldRecipientAccountId.setColumns(10);
		
		fieldAmount = new JTextField();
		fieldAmount.setBounds(224, 66, 140, 25);
		panelSingle.add(fieldAmount);
		fieldAmount.setColumns(10);
		
		fieldScsPin = new JTextField();
		fieldScsPin.setBounds(224, 106, 140, 25);
		panelSingle.add(fieldScsPin);
		fieldScsPin.setColumns(10);
		
		JButton btnGenerateTanForSingle = new JButton("Generate TAN");
		btnGenerateTanForSingle.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
		btnGenerateTanForSingle.setForeground(Color.WHITE);
		btnGenerateTanForSingle.setBackground(Color.DARK_GRAY);
		btnGenerateTanForSingle.addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				if (isValidSingleTransaction()) {
					tanGenerator = new TanGenerator();
					String tan = tanGenerator.getTan(fieldRecipientAccountId.getText() + fieldAmount.getText() + fieldScsPin.getText());
					displayTan("_SINGLE", tan);
				}				
			}
		});
		btnGenerateTanForSingle.setBounds(130, 155, 154, 25);
		panelSingle.add(btnGenerateTanForSingle);
		
		textPaneSingle = new JTextPane();
		textPaneSingle.setText("");
		textPaneSingle.setBounds(23, 192, 300, 20);
		textPaneSingle.setContentType("text/html");
		textPaneSingle.setEditable(false);
		panelSingle.add(textPaneSingle);
		
		JPanel panelBatch = new JPanel();
		panelBatch.setBackground(Color.WHITE);
		tabbedPane.addTab("Batch Transactions", null, panelBatch, null);
		panelBatch.setLayout(null);		
		
		JFilePicker filePicker = new JFilePicker("Choose a file* ", "Browse");
		filePicker.setBackground(Color.WHITE);
        filePicker.setMode(JFilePicker.MODE_OPEN);
        filePicker.setBounds(12, 72, 409, 71);
        
        filePicker.addFileTypeFilter(".txt", "Text Files");
        panelBatch.add(filePicker);
        
        JButton btnGenerateTanForBatch = new JButton("Generate TAN");
        btnGenerateTanForBatch.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
        btnGenerateTanForBatch.setForeground(Color.WHITE);
        btnGenerateTanForBatch.setBackground(Color.DARK_GRAY);
        btnGenerateTanForBatch.addActionListener(new ActionListener() {
        	@Override
			public void actionPerformed(ActionEvent e) {
        		LineBorder errorField;
        		String scsPin = fieldScsPinBatch.getText().trim();
        		String filePath = filePicker.getSelectedFilePath().trim();

        		/*Check if the SCS Pin entered is empty*/
        		if (scsPin.isEmpty()) {
        			errorField = new LineBorder(Color.RED, 1, true);		
        			textPaneBatch.setText("Please enter a valid SCS pin.");
        			fieldScsPinBatch.setBorder(errorField);
        			return;
        		}        		
        		/*Check if SCS Pin entered is valid*/
        		if (!isValidScsPin(scsPin)) {
        			errorField = new LineBorder(Color.RED, 1, true);
        			textPaneBatch.setText("Incorrect SCS Pin for the transfer.");
        			fieldScsPinBatch.setBorder(errorField);
        			return;
        		}
        		/*Check if no file is provided*/	
        		if (filePath.isEmpty()) {
        			textPaneBatch.setText("Please choose a file.");
        			return;
        		} 
        		        		
    			textPaneBatch.setText("");
    			
    			try {
					BufferedReader reader = new BufferedReader(new FileReader(filePath));
					String fileContent = "", line;
					while((line = reader.readLine()) != null) {						
						fileContent += line;
					}
					if (reader != null) {
						reader.close();
					}
					tanGenerator = new TanGenerator();
					String tan = tanGenerator.getTan(scsPin + fileContent.trim());
					displayTan("_BATCH", tan);
				} catch (FileNotFoundException e1) {					
					e1.printStackTrace();
				} catch (IOException e1) {
					e1.printStackTrace();
				}        		
        	}
        });        
        btnGenerateTanForBatch.setBounds(130, 155, 154, 25);
        panelBatch.add(btnGenerateTanForBatch);
        
        textPaneBatch = new JTextPane();
        textPaneBatch.setText("");
        textPaneBatch.setBounds(23, 192, 300, 20);
        textPaneBatch.setContentType("text/html");
		textPaneBatch.setEditable(false);
        panelBatch.add(textPaneBatch);
        
        JLabel lblScsPinBatch = new JLabel("SCS Pin*");
        lblScsPinBatch.setFont(new Font("Century Schoolbook L", Font.BOLD, 12));
        lblScsPinBatch.setBounds(23, 38, 140, 25);
        panelBatch.add(lblScsPinBatch);
        
        fieldScsPinBatch = new JTextField();
        fieldScsPinBatch.setBounds(111, 35, 140, 25);
        panelBatch.add(fieldScsPinBatch);
        fieldScsPinBatch.setColumns(10);
	}
	
	/**
	 * Verifies if the all the required fields in the form are filled. 
	 */
	private Boolean isFormFilled() {
		String msgRequiredFields = "Please fill all the required fields.";		
		Boolean isFormFilled = true;
		
		fieldAmount.setBorder(null);
		fieldRecipientAccountId.setBorder(null);
		fieldScsPin.setBorder(null);
		
		/*Check if the Amount entered is empty*/
		if (fieldAmount.getText().trim().isEmpty()) {
			markFieldForError(fieldAmount);
			isFormFilled = false;
		}		
		
		/*Check if the Recipient Account Id entered is empty*/
		if (fieldRecipientAccountId.getText().trim().isEmpty()) {
			markFieldForError(fieldRecipientAccountId);
			isFormFilled = false;
		}
				
		/*Check if the SCS Pin entered is empty*/
		if (fieldScsPin.getText().trim().isEmpty()) {
			markFieldForError(fieldScsPin);
			isFormFilled = false;
		}
		/*Set appropriate error message*/ 
		if (!isFormFilled) {
			setMessage(msgRequiredFields);
		}
		return isFormFilled;				
	}
	
	/**
	 * Highlights a field to indicate error.
	 */
	private void markFieldForError(JTextField field) {
		LineBorder errorField = new LineBorder(Color.RED, 1, true);		
		field.setBorder(errorField);
	}
	
	/**
	 * Highlights a field to indicate error and also displays the message specified.
	 */
	private void markFieldForError(JTextField field, String message) {
		LineBorder errorField = new LineBorder(Color.RED, 1, true);		
		setMessage(message);
		field.setBorder(errorField);
	}
	
	/**
	 * Displays the specified message.
	 */
	private void setMessage(String message) {
		textPaneSingle.setText(message);
	}
	/**
	 * Displays the tan.
	 */
	private void displayTan(String mode, String tan) {
		String message = "Your TAN is <b>" + tan + "</b>";
		if (mode == "_SINGLE") 
			textPaneSingle.setText(message);
		else if (mode == "_BATCH")
			textPaneBatch.setText(message);
	}
	
	/**
	 * Verifies if the data for the single transaction is valid.
	 */
	private Boolean isValidSingleTransaction() {						
		Pattern numeric = Pattern.compile("[0-9]*\\.?[0-9]+");
		Matcher matcher;
		
		if (isFormFilled()) {
			fieldAmount.setBorder(null);
			fieldRecipientAccountId.setBorder(null);
			fieldScsPin.setBorder(null);
			
			matcher = numeric.matcher(fieldAmount.getText().trim());
			if (matcher.matches()) {
				Float amount = Float.parseFloat(matcher.group(0));
				/*Return if the amount entered is invalid(i.e., negative or 0)*/
				if (amount <= 0) {
					markFieldForError(fieldAmount, "Incorrect Amount for the transfer");					
					return false;	
				}	
			} else {
				markFieldForError(fieldAmount, "Incorrect Amount for the transfer");
				return false;
			}
			
			matcher = numeric.matcher(fieldRecipientAccountId.getText().trim());
			if (matcher.matches()) {
				Integer recipientAccountId = Integer.parseInt(matcher.group(0));
				/*Return if the recipient account id entered is invalid(i.e., negative or 0)*/
				if (recipientAccountId <= 0) {
					markFieldForError(fieldRecipientAccountId, "Incorrect Recipient Account Id for the transfer");
					return false;
				}
			} else {
				markFieldForError(fieldRecipientAccountId, "Incorrect Recipient Account Id for the transfer");				
				return false;
			}
			
			if (isValidScsPin(fieldScsPin.getText().trim())) {
				markFieldForError(fieldScsPin, "Incorrect SCS Pin for the transfer");				
				return false;
			} else {
				setMessage("");
				return true;
			}			
		}
		return false;
	}
	
	private Boolean isValidScsPin(String scsPin) {		
		/*Return if the SCS Pin entered does not contain 6 characters.*/
		if (scsPin.length() != 6) {							
			return false;
		}
		return true;
	}
}