Feature: Migration Adapter
  In order to migrate files to a new storage location and make use of new storage location benefits
  As an organization
  I need direct file operations to the new storage location and fall back to the old storage if the file is not available.

  Scenario: Writing a new file
    Given an empty source
    And an empty destination
    When I write "Hello World" to the file "fileA.txt"
    Then I should see the "fileA.txt" in the destination
    And the contents of "fileA.txt" in the destination should be "Hello World"
    And the source should not contain "fileA.txt"

  Scenario: Writing from a stream
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I open a stream for "fileA.txt"
    And I write the stream to "fileB.txt"
    Then I should see the "fileB.txt" in the destination
    Then the contents of "fileB.txt" in the destination should be "Hello World"
    
  Scenario: Update a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I update the file "fileA.txt" with "Goodbye World"
    Then the contents of "fileA.txt" in the source should be "Goodbye World"

  Scenario: Update a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I update the file "fileA.txt" with "Goodbye World"
    Then the contents of "fileA.txt" in the destination should be "Goodbye World"
    And the contents of "fileA.txt" in the source should be "Hello World"
    
  Scenario: Update a file that has not been migrated to the destination from a stream
    Given the source contains "fileA.txt" with contents "wide Web"
    And the source contains "fileB.txt" with contents "Hello World"
    And an empty destination
    When I open a stream for "fileA.txt"
    And I update "fileB.txt" with the stream
    Then the contents of "fileB.txt" in the source should be "wide Web"

  Scenario: Updating a file that has been migrated to the destination from a stream
    Given the source contains "fileA.txt" with contents "wide Web"
    And the source contains "fileB.txt" with contents "Hello World"
    And the destination contains "fileB.txt" with contents "Hello world"
    When I open a stream for "fileA.txt"
    And I update "fileB.txt" with the stream
    Then the contents of "fileB.txt" in the destination should be "wide Web"
    And the contents of "fileB.txt" in the source should be "Hello World"

  Scenario: Read a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I read the file "fileA.txt"
    Then I should see "Hello World"
    
  Scenario: Read a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I read the file "fileA.txt"
    Then I should see "Hello World"

  Scenario: Read a file that has been migrated to the destination and the destination has been updated
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World!"
    When I read the file "fileA.txt"
    Then I should see "Hello World!"

  Scenario: Read a stream that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I read "fileA.txt" into a stream
    Then the stream should contain "Hello World"
    
  Scenario: Read a stream that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I read "fileA.txt" into a stream
    Then the stream should contain "Hello World"

  Scenario: Read a stream that has been migrated to the destination and the destination has been updated
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World!"
    When I read "fileA.txt" into a stream
    Then the stream should contain "Hello World!"

  Scenario: Copy a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I copy "fileA.txt" to "fileB.txt"
    Then the contents of "fileB.txt" in the source should be "Hello World"
    And the source should contain "fileA.txt"

  Scenario: Copy a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I copy "fileA.txt" to "fileB.txt"
    Then the contents of "fileB.txt" in the destination should be "Hello World"
    And the destination should contain "fileA.txt"

  Scenario: Rename a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I rename "fileA.txt" to "fileB.txt"
    Then the contents of "fileB.txt" in the source should be "Hello World"
    And the source should not contain "fileA.txt"

  Scenario: Rename a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I rename "fileA.txt" to "fileB.txt"
    Then the contents of "fileB.txt" in the destination should be "Hello World"
    And the contents of "fileB.txt" in the source should be "Hello World"
    And the destination should not contain "fileA.txt"
    And the source should not contain "fileA.txt"

  Scenario: Delete a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I delete "fileA.txt"
    Then the source should not contain "fileA.txt"

  Scenario: Delete a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I delete "fileA.txt"
    Then the destination should not contain "fileA.txt"
    Then the source should not contain "fileA.txt"


  Scenario: File exists on a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And an empty destination
    When I check if "fileA.txt" exists
    Then it should say the file exists

  Scenario: File exists on a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello World"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I check if "fileA.txt" exists
    Then it should say the file exists

  Scenario: Create a new directory
    Given an empty source
    And an empty destination
    When I create the directory "foo"
    Then the destination should contain the directory "foo"

  Scenario: Delete a directory that has not been migrated
    Given the source contains the directory "foo"
    And an empty destination
    When I delete the directory "foo"
    Then the source should not contain the directory "foo"

  Scenario: Delete a directory that has been migrated
    Given the source contains the directory "foo"
    And the destination contains the directory "foo"
    When I delete the directory "foo"
    Then the destination should not contain the directory "foo"
    And the source should not contain the directory "foo"

  Scenario: List the contents of a directory that has not been migrated to the destination
    Given the source contains the directory "foo"
    And the source contains "foo/fileA.txt" with contents "Hello World"
    And the destination contains "fileB.txt" with contents "Biz Buzz"
    When I list the contents of "foo"
    Then I should see "fileA.txt"

  Scenario: List the contents of a directory that has been migrated to the destination
    Given the source contains the directory "foo"
    And the source contains "foo/fileA.txt" with contents "Hello World"
    And the source contains "foo/fileB.txt" with contents "Hello World Wide Web"
    And the destination contains the directory "foo"
    And the destination contains "foo/fileA.txt" with contents "Hello World"
    And the destination contains "foo/fileB.txt" with contents "Hello World Wide Web"
    When I list the contents of "foo"
    Then I should see "fileA.txt, fileB.txt"

  Scenario: List the contents of a directory that has been partially migrated to the destination
    Given the source contains the directory "foo"
    And the source contains "foo/fileA.txt" with contents "Hello World"
    And the source contains "foo/fileB.txt" with contents "Hello World Wide Web"
    And the destination contains the directory "foo"
    And the destination contains "foo/fileA.txt" with contents "Hello World"
    And the destination contains "foo/fileC.txt" with contents "Goodbye cruel world"
    When I list the contents of "foo"
    Then I should see "fileA.txt, fileB.txt, fileC.txt"

  Scenario: File size on a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And an empty destination
    When I check the file size of "fileA.txt"
    Then I should see "5"

  Scenario: File size on a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And the destination contains "fileA.txt" with contents "Hello"
    When I check the file size of "fileA.txt"
    Then I should see "5"

  Scenario: File size on a file that has been migrated to the destination and the destination has been updated
    Given the source contains "fileA.txt" with contents "Hello"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I check the file size of "fileA.txt"
    Then I should see "11"

  Scenario: Metadata on a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And an empty destination
    When I get the metadata for "fileA.txt"
    Then I should see "file, fileA.txt, 5"

  Scenario: Metadata on a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And the destination contains "fileA.txt" with contents "Hello"
    When I get the metadata for "fileA.txt"
    Then I should see "file, fileA.txt, 5"

  Scenario: Metadata on a file that has been migrated to the destination and the destination has been updated
    Given the source contains "fileA.txt" with contents "Hello"
    And the destination contains "fileA.txt" with contents "Hello World"
    When I get the metadata for "fileA.txt"
    Then I should see "file, fileA.txt, 11"
    
  Scenario: Timestamp on a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And the source "fileA.txt" was created at "1468003283"
    And an empty destination
    When I get the timestamp for "fileA.txt"
    Then I should see "1468003283"
    
  Scenario: Timestamp on a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And the source "fileA.txt" was created at "1468003283"
    And the destination contains "fileA.txt" with contents "Hello"
    And the destination "fileA.txt" was created at "1468005000"
    When I get the timestamp for "fileA.txt"
    Then I should see "1468005000"

  Scenario: Mimetype on a file that has not been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And an empty destination
    When I get the mimetype for "fileA.txt"
    Then I should see "text/plain"

  Scenario: Mimetype on a file that has been migrated to the destination
    Given the source contains "fileA.txt" with contents "Hello"
    And the destination contains "fileA.txt" with contents "Hello"
    When I get the mimetype for "fileA.txt"
    Then I should see "text/plain"