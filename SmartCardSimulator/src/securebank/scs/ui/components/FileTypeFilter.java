/**
 * FileTypePicker class
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 *
 * Part of code taken from http://www.codejava.net/java-se/swing/file-picker-component-in-swing
 */

package securebank.scs.ui.components;
import java.io.File;
import javax.swing.filechooser.FileFilter;
 
public class FileTypeFilter extends FileFilter {
 
    private String extension;
    private String description;
     
    public FileTypeFilter(String extension, String description) {
        this.extension = extension;
        this.description = description;
    }
     
    @Override
    public boolean accept(File file) {
        if (file.isDirectory()) {
            return true;
        }
        return file.getName().toLowerCase().endsWith(extension);
    }
     
    @Override
	public String getDescription() {
        return description + String.format(" (*%s)", extension);
    }
}