

###############################
## !!! DEV Use only
###############################
import src.mysql_functions as mysql_functions
mysqldb = mysql_functions.MySqlDb()
mysqldb.delete_scores_all()
print("All Scores have been deleted!!!!")