txt = "Demo"

# Returns True if the string is an identifier.
# A string is considered a valid identifier if it only contains 
# alphanumeric letters (a-z) and (0-9), or underscores (_). 
# A valid identifier cannot start with a number, or contain any spaces.
x = txt.isidentifier()

print(x)